export const rotatingText = async () => {
  if (!window.Alpine) {
    console.error('Alpine.js is not loaded');
    return;
  }

  window.Alpine.data('rotatingText', (config = {}) => ({
    words: config.words || [],
    wordIndex: 0,
    delay: config.delay || 2000,
    capitalize: config.capitalize !== undefined ? config.capitalize : false,
    addPeriod: config.addPeriod !== undefined ? config.addPeriod : false,

    init() {
      setInterval(() => {
        this.wordIndex = (this.wordIndex + 1) % this.words.length;
      }, this.delay);
    },

    get currentText() {
      let text = this.words[this.wordIndex];
      if (this.capitalize) {
        text = text.charAt(0).toUpperCase() + text.slice(1);
      }
      if (this.addPeriod) {
        text += '.';
      }
      return text;
    }
  }));
};
