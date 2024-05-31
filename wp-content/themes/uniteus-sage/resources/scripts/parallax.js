import {domReady} from '@roots/sage/client';
import simpleParallax from 'simple-parallax-js';

/**
 * parallax.main
 */
const main = async (err) => {
  if (err) {
    // handle hmr errors
    console.error(err)
  }

  var image = document.getElementsByClassName('simple-parallax');
  new simpleParallax(image, {
    delay: 0,
    orientation: 'down',
    scale: 1.5,
    transition: 'ease-in-out',
    overflow: true,
  });
  var image = document.getElementsByClassName('simple-parallax-hero');
  new simpleParallax(image, {
    delay: 0,
    orientation: 'up',
    scale: 1.5,
    transition: 'ease-in-out',
    overflow: false,
  });
};

/**
 * Initialize
 *
 * @see https://webpack.js.org/api/hot-module-replacement
 */
domReady(main);
import.meta.webpackHot?.accept(main);
