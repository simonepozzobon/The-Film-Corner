import ScrollReveal from 'scrollreveal'

window.sr = ScrollReveal({ reset: true });
sr.reveal('.load, .load > img', {
  duration: 200,
  delay: 200,
  scale: .9,
  opacity: 0,
  mobile: true,
  easing: 'cubic-bezier(.25, 1, .25, 1)',
});
