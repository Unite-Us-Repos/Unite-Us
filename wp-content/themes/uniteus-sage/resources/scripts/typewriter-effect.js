// typewriterModule.js
export const typewriterEffect = async () => {
  if (!window.Alpine) {
    console.error('Alpine.js is not loaded');
    return;
  }

  window.Alpine.data('typewriterEffect', (config = {}) => ({
    // Configuration with defaults
    phrases: config.phrases || ['Alpine.js Typewriter'],
    typingSpeed: config.typingSpeed || 100,
    deleteSpeed: config.deleteSpeed || 50,
    pauseBeforeDelete: config.pauseBeforeDelete || 3000,
    pauseBeforeNextPhrase: config.pauseBeforeNextPhrase || 500,
    loop: config.loop !== undefined ? config.loop : true,
    cursorChar: config.cursorChar || '|',
    showCursor: config.showCursor !== undefined ? config.showCursor : true,

    // State variables
    currentText: '',
    phraseIndex: 0,
    charIndex: 0,
    isDeleting: false,
    isPaused: false,

    // Lifecycle hooks
    init() {
      this.startTypewriter();

      // Add cursor style if needed
      if (this.showCursor && !document.querySelector('style#typewriter-style')) {
        const style = document.createElement('style');
        style.id = 'typewriter-style';
        style.textContent = `
          .typewriter-cursor {
            display: inline-block;
            animation: typewriter-blink 0.7s infinite;
          }
          @keyframes typewriter-blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
          }
        `;
        document.head.appendChild(style);
      }
    },

    // Methods
    async startTypewriter() {
      while (true) {
        await this.typePhrases();

        if (!this.loop) break;
      }

      if (typeof config.onComplete === 'function') {
        config.onComplete();
      }
    },

    async typePhrases() {
      for (this.phraseIndex = 0; this.phraseIndex < this.phrases.length; this.phraseIndex++) {
        const currentPhrase = this.phrases[this.phraseIndex];

        // Type the phrase
        for (this.charIndex = 0; this.charIndex <= currentPhrase.length; this.charIndex++) {
          this.currentText = currentPhrase.substring(0, this.charIndex);
          await this.delay(this.typingSpeed);
        }

        // Pause at the end of phrase
        await this.delay(this.pauseBeforeDelete);

        // Delete the phrase
        for (this.charIndex = currentPhrase.length; this.charIndex >= 0; this.charIndex--) {
          this.currentText = currentPhrase.substring(0, this.charIndex);
          await this.delay(this.deleteSpeed);
        }

        // Pause before next phrase
        await this.delay(this.pauseBeforeNextPhrase);
      }
    },

    delay(ms) {
      return new Promise(resolve => setTimeout(resolve, ms));
    },

    getCursorHTML() {
      return this.showCursor ? `<span class="typewriter-cursor">${this.cursorChar}</span>` : '';
    }
  }));
};

// For backwards compatibility
export default typewriterEffect;
