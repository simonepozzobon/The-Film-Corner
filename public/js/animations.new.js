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

        // Project Section Scene
        var scrollElemToWatch_2 = document.getElementById('project-title'),
          watcher_2 = scrollMonitor.create(scrollElemToWatch_2, -300),
          rev4 = new RevealFx(scrollElemToWatch_2, {
            revealSettings : {
              bgcolor: '#C0A03D',
              direction: 'bt',
              onCover: function(contentEl, revealerEl) {
                contentEl.style.opacity = 1;
              }
            }
          }),
          rev5 = new RevealFx(document.querySelector('#project-container'), {
            revealSettings : {
              bgcolor: '#FDD351',
              direction: 'rl',
              delay: 500,
              onCover: function(contentEl, revealerEl) {
                contentEl.style.opacity = 1;
              }
            }
          });

          // Project Section Scene
          var scrollElemToWatch_3 = document.getElementById('partners-title'),
            watcher_3 = scrollMonitor.create(scrollElemToWatch_3, -300),
            rev6 = new RevealFx(scrollElemToWatch_3, {
              revealSettings : {
                bgcolor: '#403B28',
                direction: 'tb',
                onCover: function(contentEl, revealerEl) {
                  contentEl.style.opacity = 1;
                }
              }
            }),
            rev7 = new RevealFx(document.querySelector('#partners-container'), {
              revealSettings : {
                bgcolor: '#C0BFB6',
                direction: 'lr',
                delay: 500,
                onCover: function(contentEl, revealerEl) {
                  contentEl.style.opacity = 1;
                }
              }
            });

            // Apps Section Scene
            var scrollElemToWatch_4 = document.getElementById('apps-title'),
              watcher_4 = scrollMonitor.create(scrollElemToWatch_4, -300),
              rev8 = new RevealFx(scrollElemToWatch_4, {
                revealSettings : {
                  bgcolor: '#8D8C86',
                  direction: 'rl',
                  onCover: function(contentEl, revealerEl) {
                    contentEl.style.opacity = 1;
                  }
                }
              }),
              rev9 = new RevealFx(document.querySelector('#apps-container'), {
                revealSettings : {
                  bgcolor: '#8D762D',
                  direction: 'bt',
                  delay: 500,
                  onCover: function(contentEl, revealerEl) {
                    contentEl.style.opacity = 1;
                  }
                }
              });

              // // Resources Section Scene
              // var scrollElemToWatch_5 = document.getElementById('resources-title'),
              //   watcher_5 = scrollMonitor.create(scrollElemToWatch_5, -300),
              //   rev10 = new RevealFx(scrollElemToWatch_5, {
              //     revealSettings : {
              //       bgcolor: '#CAB87E',
              //       direction: 'tb',
              //       onCover: function(contentEl, revealerEl) {
              //         contentEl.style.opacity = 1;
              //       }
              //     }
              //   }),
              //   rev11 = new RevealFx(document.querySelector('#resources-container'), {
              //     revealSettings : {
              //       bgcolor: '#FDD351',
              //       direction: 'lr',
              //       delay: 500,
              //       onCover: function(contentEl, revealerEl) {
              //         contentEl.style.opacity = 1;
              //       }
              //     }
              //   });

                // Login Section Scene
                var scrollElemToWatch_6 = document.getElementById('login-title'),
                  watcher_6 = scrollMonitor.create(scrollElemToWatch_6, -300),
                  rev12 = new RevealFx(scrollElemToWatch_6, {
                    revealSettings : {
                      bgcolor: '#C1C0B7',
                      direction: 'rl',
                      onCover: function(contentEl, revealerEl) {
                        contentEl.style.opacity = 1;
                      }
                    }
                  }),
                  rev13 = new RevealFx(document.querySelector('#login-container'), {
                    revealSettings : {
                      bgcolor: '#CAB87E',
                      direction: 'tb',
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

        // Project Section Init
        watcher_2.enterViewport(function() {
          rev4.reveal();
          rev5.reveal();
          watcher_2.destroy();
        });

        // Partners Section Init
        watcher_3.enterViewport(function() {
          rev6.reveal();
          rev7.reveal();
          watcher_3.destroy();
        });

        // Apps Section Init
        watcher_4.enterViewport(function() {
          rev8.reveal();
          rev9.reveal();
          watcher_4.destroy();
        });

        // Resources Section Init
        // watcher_5.enterViewport(function() {
        //   rev10.reveal();
        //   rev11.reveal();
        //   watcher_5.destroy();
        // });

        // Login Section Init
        watcher_6.enterViewport(function() {
          rev12.reveal();
          rev13.reveal();
          watcher_6.destroy();
        });

    }
  })();
