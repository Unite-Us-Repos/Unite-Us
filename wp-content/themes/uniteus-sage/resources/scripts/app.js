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

  // Load rotating text component before starting Alpine
  if (document.querySelector('[x-data^="rotatingText"]')) {
    const { rotatingText } = await import('./rotating-text.js');
    rotatingText();
  }

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
 * See https://stackoverflow.com/a/24004942/11784757
 */
const debounce = (func, wait, immediate = true) => {
  let timeout
  return () => {
    const context = this
    const args = []
    const callNow = immediate && !timeout
    clearTimeout(timeout)
    timeout = setTimeout(function () {
      timeout = null
      if (!immediate) {
        func.apply(context, args)
      }
    }, wait)
    if (callNow) func.apply(context, args)
  }
}

/**
 * Append the child element and wait for the parent's
 * dimensions to be recalculated
 * See https://stackoverflow.com/a/66172042/11784757
 */
const appendChildAwaitLayout = (parent, element) => {
  return new Promise((resolve, _) => {
    const resizeObserver = new ResizeObserver((entries, observer) => {
      observer.disconnect()
      resolve(entries)
    })
    resizeObserver.observe(element)
    parent.appendChild(element)
  })
}

document.addEventListener('alpine:init', () => {
  Alpine.data(
    'Marquee',
    ({ speed = 1, spaceX = 0, dynamicWidthElements = false }) => ({
      dynamicWidthElements,
      async init() {
        if (this.dynamicWidthElements) {
          const images = this.$el.querySelectorAll('img')
          // If there are any images, make sure they are loaded before
          // we start cloning them, since their width might be dynamically
          // calculated
          if (images) {
            await Promise.all(
              Array.from(images).map(image => {
                return new Promise((resolve, _) => {
                  if (image.complete) {
                    resolve()
                  } else {
                    image.addEventListener('load', () => {
                      resolve()
                    })
                  }
                })
              })
            )
          }
        }

        // Store the original element so we can restore it on screen resize later
        this.originalElement = this.$el.cloneNode(true)
        const originalWidth = this.$el.scrollWidth + spaceX * 4
        // Required for the marquee scroll animation
        // to loop smoothly without jumping
        this.$el.style.setProperty('--marquee-width', originalWidth + 'px')
        this.$el.style.setProperty(
          '--marquee-time',
          ((1 / speed) * originalWidth) / 100 + 's'
        )
        this.resize()
        // Make sure the resize function can only be called once every 100ms
        // Not strictly necessary but stops lag when resizing window a bit
        window.addEventListener('resize', debounce(this.resize.bind(this), 100))
      },
      async resize() {
        // Reset to original number of elements
        this.$el.innerHTML = this.originalElement.innerHTML

        // Keep cloning elements until marquee starts to overflow
        let i = 0
        while (this.$el.scrollWidth <= this.$el.clientWidth) {
          if (this.dynamicWidthElements) {
            // If we don't give this.$el time to recalculate its dimensions
            // when adding child nodes, the scrollWidth and clientWidth won't
            // change, thus resulting in this while loop looping forever
            await appendChildAwaitLayout(
              this.$el,
              this.originalElement.children[i].cloneNode(true)
            )
          } else {
            this.$el.appendChild(
              this.originalElement.children[i].cloneNode(true)
            )
          }
          i += 1
          i = i % this.originalElement.childElementCount
        }

        // Add another (original element count) of clones so the animation
        // has enough elements off-screen to scroll into view
        let j = 0
        while (j < this.originalElement.childElementCount) {
          this.$el.appendChild(this.originalElement.children[i].cloneNode(true))
          j += 1
          i += 1
          i = i % this.originalElement.childElementCount
        }
      },
    })
  )
})

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

// log the stored UTM parameters
document.addEventListener('DOMContentLoaded', function() {
  const urlParams = new URLSearchParams(window.location.search);
  const utmParams = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];

  utmParams.forEach(param => {
      const value = urlParams.get(param);
      if (value) {
          sessionStorage.setItem(param, value);
      }
  });

  // For debugging: log the stored UTM parameters
  console.log('Stored UTM Parameters:');
  utmParams.forEach(param => {
      console.log(`${param}: `, sessionStorage.getItem(param));
  });
});




document.addEventListener('DOMContentLoaded', function () {
  const desktopMenuWrapperOuter = document.querySelector('.report-menu-wrapper-outer');
  const desktopMenu = document.querySelector('.report-menu-wrapper');
  const innerContent = document.querySelector('.report-news-about'); // The content that wraps the WYSIWYG components
  const navHeight = 80; // The fixed height of the main nav at the top

  if (desktopMenuWrapperOuter) {
    let menuWrapperInitialTop = desktopMenuWrapperOuter.offsetTop; // Initial position of the menu wrapper

    // Handle sticky menu behavior
    const handleScroll = () => {
        const scrollPosition = window.scrollY;
        const innerContentBottom = innerContent.offsetTop + innerContent.offsetHeight; // Bottom of inner-content

        // Set width dynamically to match the outer wrapper width
        desktopMenu.style.width = `${desktopMenuWrapperOuter.offsetWidth}px`;

        // Check if the user has scrolled past the initial menu position
        if (scrollPosition + navHeight > menuWrapperInitialTop) {
            // Stick the menu as long as it hasn't reached the bottom of inner-content
            if (scrollPosition + navHeight + desktopMenu.offsetHeight < innerContentBottom) {
                desktopMenu.style.position = 'fixed';
                desktopMenu.style.top = `${navHeight}px`;
            } else {
                // When at the bottom of inner-content, switch to absolute positioning
                desktopMenu.style.position = 'absolute';
                // Calculate the top position based on the inner-content's bottom and menu height
                desktopMenu.style.top = `${innerContentBottom - desktopMenuWrapperOuter.offsetTop - desktopMenu.offsetHeight}px`;
            }
        } else {
            // If user is above the menu's initial position, reset to normal
            desktopMenu.style.position = 'relative';
            desktopMenu.style.top = 'unset';
        }
    };

    // Attach scroll event listener
    window.addEventListener('scroll', handleScroll);

    // On window resize, recalculate the width of the menu to match its container
    window.addEventListener('resize', function () {
        desktopMenu.style.width = `${desktopMenuWrapperOuter.offsetWidth}px`;
    });
  }
});

document.addEventListener('DOMContentLoaded', function () {
  const mobileMenu = document.getElementById('reportMobileMenu');
  const menuToggle = document.getElementById('reportMobileMenuToggle');
  const menuCloseBtn = document.getElementById('reportMenuCloseBtn');
  const keyTakeawaysSection = document.querySelector('.key-takeaways-menu');
  const menu = document.getElementById('reportDynamicMenu');
  const sections = []; // Store sections and their corresponding menu links
  const offset = 80; // Main nav (80px)

  if (mobileMenu) {
    const scrollToSectionWithOffset = (element, offset) => {
        const elementPosition = element.getBoundingClientRect().top + window.pageYOffset;
        // Detect if it's desktop or mobile and apply the correct offset
        const isDesktop = window.innerWidth >= 1024; // 1024px breakpoint for desktop
        const offsetPosition = isDesktop
            ? elementPosition - offset - 10  // Offset for desktop (Main nav - 10px)
            : elementPosition - offset - 56; // Offset for mobile (Main nav + Mobile menu - 56px)

        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth',
        });
    };

    // Toggle menu visibility on clicking the toggle button
    menuToggle.addEventListener('click', function () {
        mobileMenu.classList.toggle('hidden');
    });

    // Close the menu when clicking the close button (X)
    menuCloseBtn.addEventListener('click', function () {
        mobileMenu.classList.add('hidden');
    });

    // Set menu height to viewport height minus 80px for nav and 56px for mobile nav
    const setMenuHeight = () => {
        const menuHeight = window.innerHeight - offset;
        mobileMenu.style.height = `${menuHeight}px`;
    };

    // Retrieve the user-defined menu label from the data attribute, defaulting to "Key Takeaways" if not set
  const menuLabel = keyTakeawaysSection.getAttribute('data-menu-label') || 'Key Takeaways';

  // Add Key Takeaways link to the menu if section exists
  if (keyTakeawaysSection && menu) {
      const listItem = document.createElement('li');
      const link = document.createElement('a');

      // Use menuLabel for the text in the menu
      link.href = '#key-takeaways';
      link.innerHTML = `<div class="text-gray-500 pr-4">A.</div> <div class="head text-blue-600">${menuLabel}</div>`;
      link.classList.add('px-8', 'pt-2', 'pb-2', 'text-sm', 'font-semibold', 'no-underline', 'flex');

      // Add click event to scroll smoothly to the key-takeaways section and close the menu
      link.addEventListener('click', function (e) {
          e.preventDefault();
          scrollToSectionWithOffset(keyTakeawaysSection, offset);
          mobileMenu.classList.add('hidden'); // Close the menu

          // Remove active class from all headings and subheadings
          document.querySelectorAll('li.heading, li.subheading, div.h3-wrapper').forEach((el) => {
              el.classList.remove('active');
          });

          // Add active class to Key Takeaways
          listItem.classList.add('active');
      });

      listItem.classList.add('heading'); // Add .heading class to the li
      listItem.appendChild(link);
      menu.appendChild(listItem);

      // Add the Key Takeaways section to the sections array for active detection
      sections.push({
          id: 'key-takeaways',
          element: keyTakeawaysSection
      });
    }
}


  // Scrape WYSIWYG components for h2 and h3 elements
  const wysiwygSections = document.querySelectorAll('.wysiwyg-content');
  let h2Counter = 1;
  let h3Counter = 0;
  let h3Wrapper = null; // Wrapper for H3 elements

  wysiwygSections.forEach(wysiwyg => {
      const headings = wysiwyg.querySelectorAll('h2, h3');
      const h3Elements = Array.from(headings).filter(heading => heading.tagName.toLowerCase() === 'h3');

      headings.forEach(heading => {
          const headingText = heading.textContent.trim(); // Get trimmed heading text
          const currentHeading = heading;

          // Only add to the menu if the heading has non-empty text
          if (headingText) {
              const listItem = document.createElement('li');
              const link = document.createElement('a');
              let counterText = '';

              // Set up the scroll behavior for H2 and H3
              link.addEventListener('click', function (e) {
                  e.preventDefault();
                  scrollToSectionWithOffset(heading, offset); // Scroll to the heading
                  mobileMenu.classList.add('hidden'); // Close the menu

                  // Add active class to clicked li.heading and remove from others only if it's a heading
                  if (listItem.classList.contains('heading')) {
                      document.querySelectorAll('li.heading, div.h3-wrapper').forEach((el) => {
                          el.classList.remove('active');
                      });

                      // Add active class to clicked heading
                      listItem.classList.add('active');

                      // If li.parent has a sibling h3-wrapper, also add active class to the h3-wrapper
                      const siblingH3Wrapper = listItem.nextElementSibling;
                      if (listItem.classList.contains('parent') && siblingH3Wrapper && siblingH3Wrapper.classList.contains('h3-wrapper')) {
                          siblingH3Wrapper.classList.add('active');
                      }
                  } else if (listItem.classList.contains('subheading')) {
                      // If a subheading is clicked, activate the closest heading and its h3-wrapper
                      scrollToSectionWithOffset(heading, offset);

                      const closestHeading = listItem.closest('.h3-wrapper').previousElementSibling;
                      const parentH3Wrapper = listItem.closest('.h3-wrapper');

                      // Ensure active class is only added to the correct li.parent and div.h3-wrapper
                      if (closestHeading && closestHeading.classList.contains('parent')) {
                          document.querySelectorAll('li.heading, div.h3-wrapper').forEach((el) => {
                              el.classList.remove('active');
                          });

                          // Add active class to closest li.parent
                          closestHeading.classList.add('active');
                          // Add active class to the parent div.h3-wrapper
                          parentH3Wrapper.classList.add('active');
                      }

                      mobileMenu.classList.add('hidden');
                  }
              });

              // Check if it's an H2 or H3 and adjust the numbering or styling
              if (heading.tagName.toLowerCase() === 'h2') {
                  // When encountering an H2, close any open H3 wrapper
                  if (h3Wrapper) {
                      menu.appendChild(h3Wrapper); // Append the H3 wrapper to the menu
                      h3Wrapper = null; // Reset the wrapper
                  }

                  counterText = `<div class="text-gray-500 pr-4">${h2Counter}.</div> `;
                  h2Counter++; // Increment H2 counter
                  h3Counter = 0; // Reset H3 counter after each H2
                  link.classList.add('px-8', 'pt-2', 'pb-2', 'text-sm', 'font-semibold', 'no-underline', 'flex', 'items-baseline'); // Regular styling for H2

                  // Append the link to the list item and directly to the menu for H2
                  link.href = `#${heading.id || 'h2-' + h2Counter}`;
                  // Add heading id attribute if it doesn't exist
                  // This ensures that the same heading doesn't get multiple ids
                  // and allows for smooth scrolling
                  // to the same heading

                  if (!heading.id) {
                     // add id attribute to currentHeading
                    currentHeading.id = heading.id || 'h2-' + h2Counter;
                  }

                  // Set the inner HTML for the link
                  link.innerHTML = `${counterText}<div class="head text-blue-600 no-underline pb-2 pt-2">${headingText}</div>`;
                  listItem.classList.add('heading'); // Add .heading class to li with H2
                  listItem.appendChild(link);
                  menu.appendChild(listItem);

                  // Add to sections array for scroll detection
                  sections.push({
                      id: heading.id || 'h2-' + h2Counter,
                      element: heading
                  });

              } else if (heading.tagName.toLowerCase() === 'h3') {
                  // Create a new wrapper if one doesn't exist
                  if (!h3Wrapper) {
                      h3Wrapper = document.createElement('div'); // Wrapper for all H3 elements under the current H2
                      h3Wrapper.classList.add('h3-wrapper', 'pt-2', 'pb-2'); // Add the vertical line style
                  }

                  h3Counter++;

                  // Create the H3 link without numbering (just the vertical bar and indentation)
                  link.classList.add('text-sm', 'font-medium', 'pl-6', 'pr-6', 'relative', 'flex', 'no-underline'); // Indent H3
                  link.href = `#${heading.id || 'h3-' + h3Counter}`;
                  link.innerHTML = `<div class="vertical-line"></div><div class="head text-blue-600 no-underline">${headingText}</div>`;
                  listItem.classList.add('subheading'); // Add .subheading class to li with H3

                  // Append padding only to middle elements
                  if (h3Elements.length > 1) {
                      if (h3Counter === 1) {
                          link.classList.add('pt-0'); // No padding-top for first element
                      } else if (h3Counter === h3Elements.length) {
                          link.classList.add('pb-0'); // No padding-bottom for last element
                      } else {
                          link.classList.add('pt-2', 'pb-2'); // Padding for middle elements
                      }
                  }

                  // Append the H3 link to the list item
                  listItem.appendChild(link);

                  // Append the list item to the H3 wrapper
                  h3Wrapper.appendChild(listItem);

                  // Add to sections array for scroll detection
                  sections.push({
                      id: heading.id || 'h3-' + h3Counter,
                      element: heading
                  });
              }
          }
      });

      // If there is an open H3 wrapper after processing all headings, append it to the menu
      if (h3Wrapper) {
          menu.appendChild(h3Wrapper);
      }

      // Check for H2 elements with an adjacent h3-wrapper and add the 'parent' class
      const listItems = menu.querySelectorAll('li.heading');
      listItems.forEach((li) => {
          const nextSibling = li.nextElementSibling;
          if (nextSibling && nextSibling.classList.contains('h3-wrapper')) {
              li.classList.add('parent'); // Add 'parent' class if h3-wrapper is next sibling
          }
      });
  });
});


document.addEventListener('DOMContentLoaded', function () {
  let offset = 100; // Offset for fixed navigation (80px)

  // Function to scroll smoothly to a section
  const smoothScrollToSection = (element) => {
      if (window.innerWidth <= 1024) {
          offset = 160; // Offset for desktop (80px + 100px for the menu)
      } else {
        offset = 100; // Offset for mobile (80px)
      }

      const elementPosition = element.getBoundingClientRect().top + window.pageYOffset;
      const offsetPosition = elementPosition - offset;

      window.scrollTo({
          top: offsetPosition,
          behavior: 'smooth',
      });
  };

  // Attach event listeners to all internal links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
          e.preventDefault();
          const targetId = this.getAttribute('href').substring(1); // Get the ID without the #
          const targetElement = document.getElementById(targetId);

          // Scroll to the section if the target exists
          if (targetElement) {
              smoothScrollToSection(targetElement);
              reportMenuCloseBtn.click(); // Close the mobile menu after scrolling
          }
      });
  });
});


  // reports image lightbox
document.addEventListener('DOMContentLoaded', function () {
  const lightbox = document.getElementById('reportlightbox');
  const lightboxImage = document.getElementById('reportlightbox-image');
  const close = document.querySelector('.report .close');
  const wysiwygImages = document.querySelectorAll('.report .wysiwyg-content img');

  let isDragging = false;
  let startX, startY, scrollLeft, scrollTop;

  if (lightbox) {
    wysiwygImages.forEach(img => {
        img.addEventListener('click', function () {
            lightbox.style.display = 'block';
            lightboxImage.src = this.src;
        });
    });

    close.addEventListener('click', function () {
        lightbox.style.display = 'none';
    });

    // Zooming in/out by scrolling
    lightboxImage.addEventListener('wheel', function (e) {
        e.preventDefault();
        let scale = Number(this.getAttribute('data-scale')) || 1;
        scale += e.deltaY * -0.001;
        scale = Math.min(Math.max(1, scale), 4); // Limit scale between 1 and 4
        this.style.transform = `scale(${scale})`;
        this.setAttribute('data-scale', scale);
    });

    // Drag to pan
    lightboxImage.addEventListener('mousedown', function (e) {
        isDragging = true;
        lightboxImage.classList.add('grabbing');
        startX = e.pageX - lightboxImage.offsetLeft;
        startY = e.pageY - lightboxImage.offsetTop;
        scrollLeft = lightbox.scrollLeft;
        scrollTop = lightbox.scrollTop;
    });

    lightboxImage.addEventListener('mousemove', function (e) {
        if (!isDragging) return;
        e.preventDefault();
        const x = e.pageX - startX;
        const y = e.pageY - startY;
        lightboxImage.style.transform = `translate(${x}px, ${y}px) scale(${lightboxImage.getAttribute('data-scale') || 1})`;
    });

    lightboxImage.addEventListener('mouseup', function () {
        isDragging = false;
        lightboxImage.classList.remove('grabbing');
    });

    lightboxImage.addEventListener('mouseleave', function () {
        isDragging = false;
        lightboxImage.classList.remove('grabbing');
    });
  }
});
