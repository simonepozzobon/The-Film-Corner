(function() {
    // Fake loading.
    init();

    function init() {
      var rev1 = new RevealFx(document.querySelector('#el-1'), {
        revealSettings : {
          bgcolor: '#7f40f1',
          onCover: function(contentEl, revealerEl) {
            contentEl.style.opacity = 1;
          }
        }
      });
      rev1.reveal({
        bgcolor: '#c1c0b7',
        duration: 300,
        direction: 'tb',
        onStart: function(contentEl, revealerEl) {
          anime.remove(contentEl);
          contentEl.style.opacity = 0;
        },
        onCover: function(contentEl, revealerEl) {
          anime({
            targets: contentEl,
            duration: 500,
            delay: 50,
            easing: 'easeOutBounce',
            translateY: [-40,0],
            opacity: {
              value: [0,1],
              duration: 300,
              easing: 'linear'
            }
          });
        }
      });

      //News Section Scene
      var scrollElemToWatch_1 = document.getElementById('news-title'),
        watcher_1 = scrollMonitor.create(scrollElemToWatch_1, -300),
        rev2 = new RevealFx(scrollElemToWatch_1, {
          revealSettings : {
            bgcolor: '#FDD351',
            direction: 'rl',
            onCover: function(contentEl, revealerEl) {
              contentEl.style.opacity = 1;
            }
          }
        }),
        rev3 = new RevealFx(document.querySelector('#news-container'), {
          revealSettings : {
            bgcolor: '#c1c0b7',
            direction: 'lr',
            delay: 500,
            onCover: function(contentEl, revealerEl) {
              contentEl.style.opacity = 1;
            }
          }
        });



        // News Section Init
        watcher_1.enterViewport(function() {
          rev2.reveal();
          rev3.reveal();
          watcher_1.destroy();
        });

    }
  })();
