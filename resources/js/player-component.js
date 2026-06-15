import { AudioEngine } from './audio-engine.js';

const STORAGE_KEY = 'nwader_player_state';

const SAVE_DEBOUNCE_MS = 3000;

function saveState(state) {
    try {
        sessionStorage.setItem(STORAGE_KEY, JSON.stringify(state));
    } catch (_) {}
}

function loadState() {
    try {
        const raw = sessionStorage.getItem(STORAGE_KEY);
        return raw ? JSON.parse(raw) : null;
    } catch (_) {
        return null;
    }
}

function clearSavedState() {
    try {
        sessionStorage.removeItem(STORAGE_KEY);
    } catch (_) {}
}

let lastSave = 0;

function debouncedSave(state) {
    const now = Date.now();
    if (now - lastSave >= SAVE_DEBOUNCE_MS) {
        saveState(state);
        lastSave = now;
    }
}

const engine = new AudioEngine();

document.addEventListener('alpine:init', () => {
    if (Alpine.store('player')) return;

    Alpine.store('player', {
        track: null,
        playing: false,
        loading: false,
        currentTime: 0,
        duration: 0,
        volume: 1,
        speed: 1,
        error: null,

        init() {
            const saved = loadState();
            clearSavedState();

            if (saved?.track) {
                this.track = saved.track;
                this.currentTime = saved.currentTime || 0;
                this.playing = saved.playing || false;
                this.volume = saved.volume ?? 1;
                this.speed = saved.speed ?? 1;

                engine.setVolume(this.volume);
                engine.setSpeed(this.speed);
                engine.load(this.track.audio_url);

                if (saved.currentTime > 0) {
                    const seekTo = saved.currentTime;
                    const onMeta = () => {
                        engine.seek(Math.min(seekTo, engine.duration || 0));
                        engine.off('loadedmetadata', onMeta);
                        if (saved.playing) {
                            setTimeout(() => engine.play(), 50);
                        }
                    };
                    engine.on('loadedmetadata', onMeta);
                } else if (saved.playing) {
                    this.loading = true;
                    engine.on('loadedmetadata', () => {
                        setTimeout(() => engine.play(), 50);
                    });
                }
            }

            engine.on('timeupdate', () => {
                this.currentTime = engine.currentTime;
                const st = {
                    track: this.track,
                    currentTime: engine.currentTime,
                    playing: !engine.paused,
                    volume: engine.volume,
                    speed: engine.speed,
                };
                debouncedSave(st);
            });

            engine.on('loadedmetadata', () => {
                this.duration = engine.duration;
                this.loading = false;
                this.error = null;
            });

            engine.on('loadstart', () => {
                this.loading = true;
                this.error = null;
            });

            engine.on('canplay', () => {
                this.loading = false;
            });

            engine.on('play', () => {
                this.playing = true;
            });

            engine.on('pause', () => {
                this.playing = false;
            });

            engine.on('ended', () => {
                this.playing = false;
                this.currentTime = 0;
                clearSavedState();
            });

            engine.on('error', () => {
                this.loading = false;
                const err = engine.audio.error;
                this.error = err ? `فشل تحميل الصوت (كود ${err.code})` : 'خطأ في تشغيل الصوت';
            });

            engine.on('waiting', () => {
                this.loading = true;
            });

            engine.on('playing', () => {
                this.loading = false;
            });
        },

        play(track) {
            if (!track || !track.audio_url) return;
            if (this.track && this.track.id === track.id) {
                if (engine.paused) {
                    engine.play();
                }
                return;
            }
            this.track = track;
            this.currentTime = 0;
            this.duration = 0;
            this.playing = false;
            this.error = null;
            engine.load(track.audio_url);
            setTimeout(() => engine.play(), 100);
        },

        toggle() {
            if (!this.track) return;
            if (engine.paused) {
                engine.play();
            } else {
                engine.pause();
            }
        },

        seek(time) {
            engine.seek(time);
            this.currentTime = time;
        },

        skip(seconds) {
            const t = engine.currentTime + seconds;
            engine.seek(Math.max(0, Math.min(t, engine.duration || 0)));
        },

        setVolume(vol) {
            engine.setVolume(vol);
            this.volume = vol;
        },

        setSpeed(speed) {
            engine.setSpeed(speed);
            this.speed = speed;
        },

        stop() {
            engine.pause();
            this.track = null;
            this.playing = false;
            this.currentTime = 0;
            this.duration = 0;
            clearSavedState();
        },

        formatTime(s) {
            if (!s || isNaN(s)) return '00:00';
            const m = Math.floor(s / 60);
            const sec = Math.floor(s % 60);
            return `${String(m).padStart(2, '0')}:${String(sec).padStart(2, '0')}`;
        },
    });

    Alpine.data('playerUI', () => ({
        dragging: false,
        trackRect: null,

        init() {
            this.$el.addEventListener('keydown', (e) => {
                const store = Alpine.store('player');
                if (!store.track) return;
                switch (e.key) {
                    case ' ':
                        e.preventDefault();
                        store.toggle();
                        break;
                    case 'ArrowRight':
                        e.preventDefault();
                        store.skip(10);
                        break;
                    case 'ArrowLeft':
                        e.preventDefault();
                        store.skip(-10);
                        break;
                    case 'm':
                    case 'M':
                        store.setVolume(store.volume > 0 ? 0 : 1);
                        break;
                }
            });
        },

        startDrag(e) {
            this.dragging = true;
            this.trackRect = this.$refs.progressTrack.getBoundingClientRect();
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            this._updateFromClientX(clientX);
        },

        onDrag(e) {
            if (!this.dragging) return;
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            this._updateFromClientX(clientX);
        },

        stopDrag() {
            this.dragging = false;
        },

        _updateFromClientX(clientX) {
            if (!this.trackRect) return;
            const player = Alpine.store('player');
            const pct = Math.max(0, Math.min(1, (clientX - this.trackRect.left) / this.trackRect.width));
            player.seek(pct * player.duration);
        },

        progressStyle() {
            const player = Alpine.store('player');
            const pct = player.duration ? (player.currentTime / player.duration * 100) : 0;
            return { width: pct + '%' };
        },

        thumbStyle() {
            const player = Alpine.store('player');
            const pct = player.duration ? (player.currentTime / player.duration * 100) : 0;
            return { left: pct + '%' };
        },

        clickTrack(e) {
            if (this.dragging) return;
            const player = Alpine.store('player');
            const rect = this.$refs.progressTrack.getBoundingClientRect();
            const pct = (e.clientX - rect.left) / rect.width;
            player.seek(pct * player.duration);
        },

        downloadTrack() {
            const track = Alpine.store('player').track;
            if (!track?.download_url) return;
            const a = document.createElement('a');
            a.href = track.download_url;
            a.setAttribute('download', '');
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        },
    }));
});

function persistState() {
    try {
        const store = Alpine.store('player');
        if (!store?.track) return;
        saveState({
            track: store.track,
            currentTime: engine.currentTime,
            playing: !engine.paused,
            volume: engine.volume,
            speed: engine.speed,
        });
    } catch (_) {}
}

window.addEventListener('beforeunload', persistState);
window.addEventListener('pagehide', persistState);

/* ------------------------------------------------------------------ */
/*  Fallback SPA navigation — catches same-origin links that are NOT  */
/*  handled by wire:navigate, preventing full page reloads.           */
/* ------------------------------------------------------------------ */
document.addEventListener('click', (e) => {
    const link = e.target.closest('a');
    if (!link) return;

    if (link.hasAttribute('wire:navigate')) return;
    if (link.hasAttribute('download')) return;
    if (link.getAttribute('target') === '_blank') return;
    if (link.href.startsWith('javascript:') || link.href.startsWith('#')) return;

    let url;
    try { url = new URL(link.href); } catch { return; }
    if (url.origin !== window.location.origin) return;
    if (url.pathname === window.location.pathname && url.search === window.location.search) return;

    e.preventDefault();
    const destination = url.pathname + url.search + url.hash;

    fetch(destination, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.text())
        .then(html => {
            const doc = new DOMParser().parseFromString(html, 'text/html');

            const newMain = doc.querySelector('main');
            const oldMain = document.querySelector('main');
            if (!newMain || !oldMain) { window.location.href = destination; return; }

            document.title = doc.title;
            oldMain.innerHTML = newMain.innerHTML;
            history.pushState({}, '', destination);

            if (window.Alpine) {
                Alpine.initTree(oldMain);
            }
        })
        .catch(() => { window.location.href = destination; });
});

window.addEventListener('popstate', () => {
    const destination = window.location.pathname + window.location.search + window.location.hash;
    fetch(destination, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.text())
        .then(html => {
            const doc = new DOMParser().parseFromString(html, 'text/html');
            const newMain = doc.querySelector('main');
            const oldMain = document.querySelector('main');
            if (!newMain || !oldMain) { window.location.reload(); return; }

            document.title = doc.title;
            oldMain.innerHTML = newMain.innerHTML;

            if (window.Alpine) {
                Alpine.initTree(oldMain);
            }
        })
        .catch(() => { window.location.reload(); });
});
