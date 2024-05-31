export const animatePlanets = async () => {
  //ASTROID VARs
  var astroidBag = document.getElementById('astroidBag');
  var astroidGraduate = document.getElementById('astroidGraduate');
  var astroidCutlery = document.getElementById('astroidCutlery');

  //ORBIT VARs
  var heroOrbit01 = document.getElementById('heroOrbit01');
  var heroOrbit02 = document.getElementById('heroOrbit02');

  //PLANET VARs
  var planet01 = document.getElementById('planet01');
  var planet02 = document.getElementById('planet02');
  var planet03 = document.getElementById('planet03');
  var planet04 = document.getElementById('planet04');

  //IMAGE VARs
  var heroImage01 = document.getElementById('heroImage01');
  var heroImage02 = document.getElementById('heroImage02');
  var heroImage03 = document.getElementById('heroImage03');

  //ANIMATE IMAGES
  var animateImages = gsap.timeline({repeat: -1, delay: 10.0, repeatDelay: 10.0 , restart: true});
  animateImages.to(heroImage02, 0, {zIndex: 20});
  animateImages.to(heroImage02, 2.0, {opacity: 1});
  animateImages.to(heroImage03, 0, {zIndex: 30});
  animateImages.to(heroImage03, 2.0, {opacity: 1}, "+=10.0");
  animateImages.to(heroImage01, 0, {opacity: 0, zIndex: 40});
  animateImages.to(heroImage01, 2.0, {opacity: 1, zIndex: 40}, "+=10.0");

  //ANIMATE ASTROIDS
  var animateAstroids = gsap.timeline({repeat: -1, yoyo: true, repeatDelay: 3.0 , restart: true});
  animateAstroids.to(astroidBag, 5.0, {ease: "power2.inOut", scale: 0.7, rotate: '0deg'});
  animateAstroids.to(astroidGraduate, 5.0, {ease: "power2.inOut", scale: 0.7, rotate: '0deg'}, "-=5.0");
  animateAstroids.to(astroidCutlery, 5.0, {ease: "power2.inOut", scale: 0.7, rotate: '0deg'}, "-=5.0");

  //ANIMATE PLANETS
  var animateOrbits = gsap.timeline({repeat: -1});
  animateOrbits.to(heroOrbit01, 30.0, {ease: "none", rotate: '-360deg'});
  animateOrbits.to(heroOrbit02, 30.0, {ease: "none", rotate: '360deg'}, "-=30.0");
  animateOrbits.to(planet01, 30.0, {ease: "none", rotate: '-360deg'}, "-=30.0");
  animateOrbits.to(planet02, 30.0, {ease: "none", rotate: '-360deg'}, "-=30.0");
  animateOrbits.to(planet03, 30.0, {ease: "none", rotate: '-360deg'}, "-=30.0");
  animateOrbits.to(planet04, 30.0, {ease: "none", rotate: '-360deg'}, "-=30.0");
}
