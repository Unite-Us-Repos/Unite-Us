import {domReady} from '@roots/sage/client';
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import collapse from '@alpinejs/collapse';
import Swiper, { Navigation, Pagination } from 'swiper/bundle';
import LazyLoad from "vanilla-lazyload";

/**
 * app.main
 */
const main = async (err) => {
  if (err) {
    // handle hmr errors
    console.error(err)
  }

  // application code
  window.Swiper = Swiper
  window.Alpine = Alpine

  Alpine.plugin(intersect)
  Alpine.plugin(collapse)
  Alpine.start()

  var lazyLoadInstance = new LazyLoad({
    // Your custom settings go here
  });

  window.lazyLoadInstance = lazyLoadInstance

  if (document.querySelector('#kh-search-results')) {
    const {searchFilters} = await import('./kh-filters.js')
    searchFilters()
  }

  if (document.querySelector('.greenhouse-filters')) {
    const {jobFilters} = await import('./job-filters.js')
    jobFilters()
  }

  if (document.querySelector('.simple-parallax')) {
    const parallax = await import('../../node_modules/simple-parallax-js/dist/simpleParallax.js')
    var image = document.getElementsByClassName('simple-parallax');
    new parallax.simpleParallax(image, {
      delay: 0,
      orientation: 'down',
      scale: 1.5,
      transition: 'ease-in-out',
      overflow: true,
    });
    var image = document.getElementsByClassName('simple-parallax-hero');
    new parallax.simpleParallax(image, {
      delay: 0,
      orientation: 'up',
      scale: 1.5,
      transition: 'ease-in-out',
      overflow: false,
    });
  }

};

/**
 * Initialize
 *
 * @see https://webpack.js.org/api/hot-module-replacement
 */
domReady(main);
import.meta.webpackHot?.accept(main);

/**
 * Components
 *
 */
window.Components = {}, window.Components.listbox = function(e) {
  return {
      init() {
          this.optionCount = this.$refs.listbox.children.length, this.$watch("activeIndex", (e => {
              this.open && (null !== this.activeIndex ? this.activeDescendant = this.$refs.listbox.children[this.activeIndex].id : this.activeDescendant = "")
          }))
      },
      activeDescendant: null,
      optionCount: null,
      open: !1,
      activeIndex: null,
      selectedIndex: 0,
      get active() {
          return this.items[this.activeIndex]
      },
      get [e.modelName || "selected"]() {
          return this.items[this.selectedIndex]
      },
      choose(e) {
          this.selectedIndex = e, this.open = !1
      },
      onButtonClick() {
          this.open || (this.activeIndex = this.selectedIndex, this.open = !0, this.$nextTick((() => {
              this.$refs.listbox.focus(), this.$refs.listbox.children[this.activeIndex].scrollIntoView({
                  block: "nearest"
              })
          })))
      },
      onOptionSelect() {
          null !== this.activeIndex && (this.selectedIndex = this.activeIndex), this.open = !1, this.$refs.button.focus()
      },
      onEscape() {
          this.open = !1, this.$refs.button.focus()
      },
      onArrowUp() {
          this.activeIndex = this.activeIndex - 1 < 0 ? this.optionCount - 1 : this.activeIndex - 1, this.$refs.listbox.children[this.activeIndex].scrollIntoView({
              block: "nearest"
          })
      },
      onArrowDown() {
          this.activeIndex = this.activeIndex + 1 > this.optionCount - 1 ? 0 : this.activeIndex + 1, this.$refs.listbox.children[this.activeIndex].scrollIntoView({
              block: "nearest"
          })
      },
      ...e
  }
}, window.Components.menu = function(e = {
  open: !1
}) {
  return {
      init() {
          this.items = Array.from(this.$el.querySelectorAll('[role="menuitem"]')), this.$watch("open", (() => {
              this.open && (this.activeIndex = -1)
          }))
      },
      activeDescendant: null,
      activeIndex: null,
      items: null,
      open: e.open,
      focusButton() {
          this.$refs.button.focus()
      },
      onButtonClick() {
          this.open = !this.open, this.open && this.$nextTick((() => {
              this.$refs["menu-items"].focus()
          }))
      },
      onButtonEnter() {
          this.open = !this.open, this.open && (this.activeIndex = 0, this.activeDescendant = this.items[this.activeIndex].id, this.$nextTick((() => {
              this.$refs["menu-items"].focus()
          })))
      },
      onArrowUp() {
          if (!this.open) return this.open = !0, this.activeIndex = this.items.length - 1, void(this.activeDescendant = this.items[this.activeIndex].id);
          0 !== this.activeIndex && (this.activeIndex = -1 === this.activeIndex ? this.items.length - 1 : this.activeIndex - 1, this.activeDescendant = this.items[this.activeIndex].id)
      },
      onArrowDown() {
          if (!this.open) return this.open = !0, this.activeIndex = 0, void(this.activeDescendant = this.items[this.activeIndex].id);
          this.activeIndex !== this.items.length - 1 && (this.activeIndex = this.activeIndex + 1, this.activeDescendant = this.items[this.activeIndex].id)
      },
      onClickAway(e) {
          if (this.open) {
              const t = ["[contentEditable=true]", "[tabindex]", "a[href]", "area[href]", "button:not([disabled])", "iframe", "input:not([disabled])", "select:not([disabled])", "textarea:not([disabled])"].map((e => `${e}:not([tabindex='-1'])`)).join(",");
              this.open = !1, e.target.closest(t) || this.focusButton()
          }
      }
  }
}, window.Components.popoverGroup = function() {
  return {
      __type: "popoverGroup",
      init() {
          let e = t => {
              document.body.contains(this.$el) ? t.target instanceof Element && !this.$el.contains(t.target) && window.dispatchEvent(new CustomEvent("close-popover-group", {
                  detail: this.$el
              })) : window.removeEventListener("focus", e, !0)
          };
          window.addEventListener("focus", e, !0)
      }
  }
}, window.Components.popover = function({
  open: e = !1,
  focus: t = !1
} = {}) {
  const i = ["[contentEditable=true]", "[tabindex]", "a[href]", "area[href]", "button:not([disabled])", "iframe", "input:not([disabled])", "select:not([disabled])", "textarea:not([disabled])"].map((e => `${e}:not([tabindex='-1'])`)).join(",");
  return {
      __type: "popover",
      open: e,
      init() {
          t && this.$watch("open", (e => {
              e && this.$nextTick((() => {
                  ! function(e) {
                      const t = Array.from(e.querySelectorAll(i));
                      ! function e(i) {
                          void 0 !== i && (i.focus({
                              preventScroll: !0
                          }), document.activeElement !== i && e(t[t.indexOf(i) + 1]))
                      }(t[0])
                  }(this.$refs.panel)
              }))
          }));
          let e = i => {
              if (!document.body.contains(this.$el)) return void window.removeEventListener("focus", e, !0);
              let n = t ? this.$refs.panel : this.$el;
              if (this.open && i.target instanceof Element && !n.contains(i.target)) {
                  let e = this.$el;
                  for (; e.parentNode;)
                      if (e = e.parentNode, e.__x instanceof this.constructor) {
                          if ("popoverGroup" === e.__x.$data.__type) return;
                          if ("popover" === e.__x.$data.__type) break
                      } this.open = !1
              }
          };
          window.addEventListener("focus", e, !0)
      },
      onEscape() {
          this.open = !1, this.restoreEl && this.restoreEl.focus()
      },
      onClosePopoverGroup(e) {
          e.detail.contains(this.$el) && (this.open = !1)
      },
      toggle(e) {
          this.open = !this.open, this.open ? this.restoreEl = e.currentTarget : this.restoreEl && this.restoreEl.focus()
      }
  }
};
document.addEventListener('DOMContentLoaded', function() {
    var cards = document.querySelectorAll('.service-icon-card.expandable');

    function collapseAllCards() {
      cards.forEach(function(card) {
        var chevronIcon = card.querySelector('.chevron-icon');
        var expandedDescription = card.querySelector('.expanded-description');
        var bgImage = card.querySelector('img');
        var evenHeight = card.querySelector('.even-height');
        var textBlock = card.querySelector('.text-block');

        if (chevronIcon) {
          chevronIcon.classList.remove('expanded');
        }
        
        if (expandedDescription) {
          expandedDescription.classList.remove('expanded');
        }
        
        if (bgImage) {
          bgImage.classList.remove('expanded');
        }
        if (evenHeight) {
          evenHeight.classList.remove('expanded');
        }
        if (textBlock) {
          textBlock.classList.remove('expanded');
        }
      });
    }

    cards.forEach(function(card) {
      card.onclick = function(event) {
        //console.log('yes');
        
        // Stop the event from propagating to the document click event
        event.stopPropagation();
        
        // Check if the clicked card is already expanded
        var isExpanded = card.querySelector('.expanded-description').classList.contains('expanded');
        
        // Collapse all other cards
        collapseAllCards();
        
        // If the clicked card was not expanded, expand it
        if (!isExpanded) {
          var chevronIcon = card.querySelector('.chevron-icon');
          var expandedDescription = card.querySelector('.expanded-description');
          var bgImage = card.querySelector('img');
          var evenHeight = card.querySelector('.even-height');
          var textBlock = card.querySelector('.text-block');

          if (chevronIcon) {
            chevronIcon.classList.add('expanded');
          }
          
          if (expandedDescription) {
            expandedDescription.classList.add('expanded');
          }
          
          if (bgImage) {
            bgImage.classList.add('expanded');
          }

          if (evenHeight) {
            evenHeight.classList.add('expanded');
          }
          if (textBlock) {
            textBlock.classList.add('expanded');
          }
        }
      };
    });
    
    // Collapse all cards when clicking outside
    document.addEventListener('click', function() {
      collapseAllCards();
    });
});

<<<<<<< HEAD
=======

>>>>>>> develop
// log the stored UTM parameters
document.addEventListener('DOMContentLoaded', function() {
  const urlParams = new URLSearchParams(window.location.search);
  const utmParams = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];

  utmParams.forEach(param => {
      const value = urlParams.get(param);
      if (value) {
          sessionStorage.setItem(param, value);
<<<<<<< HEAD
      } 
=======
      }
>>>>>>> develop
  });

  // For debugging: log the stored UTM parameters
  console.log('Stored UTM Parameters:');
  utmParams.forEach(param => {
      console.log(`${param}: `, sessionStorage.getItem(param));
  });
});
