export class AudioEngine {
    constructor() {
        this.audio = new Audio();
        this.handlers = {};
        this._setupListeners();
    }

    _setupListeners() {
        const events = [
            'timeupdate', 'loadedmetadata', 'loadstart', 'canplay',
            'play', 'pause', 'ended', 'error', 'waiting', 'playing',
        ];
        for (const event of events) {
            this.audio.addEventListener(event, (e) => this._emit(event, e));
        }
        this.audio.addEventListener('loadedmetadata', () => this._emit('durationchange'));
    }

    load(src) {
        this.audio.src = src;
        this.audio.load();
    }

    play() { return this.audio.play(); }

    pause() { this.audio.pause(); }

    seek(time) { this.audio.currentTime = time; }

    setVolume(vol) { this.audio.volume = Math.max(0, Math.min(1, vol)); }

    setSpeed(speed) { this.audio.playbackRate = speed; }

    get currentTime() { return this.audio.currentTime; }

    get duration() { return this.audio.duration || 0; }

    get paused() { return this.audio.paused; }

    get volume() { return this.audio.volume; }

    get speed() { return this.audio.playbackRate; }

    get src() { return this.audio.src; }

    destroy() {
        this.pause();
        this.audio.src = '';
        this.handlers = {};
    }

    on(event, fn) {
        if (!this.handlers[event]) this.handlers[event] = [];
        this.handlers[event].push(fn);
        return () => this.off(event, fn);
    }

    off(event, fn) {
        if (!this.handlers[event]) return;
        this.handlers[event] = this.handlers[event].filter(h => h !== fn);
    }

    _emit(event, ...args) {
        (this.handlers[event] || []).forEach(fn => fn(...args));
    }
}
