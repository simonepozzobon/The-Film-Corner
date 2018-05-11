const Lemming = function() {
  this.initPaths = function() {}

  this.generateLemming = function(i) {
    let _color = colors[Math.floor(Math.random() * n_colors)];
    let _position = -1.5 + (Math.floor((Math.random() * 100) + 1) / 100);
    let _duration = Math.floor((Math.random() * 2000) + 2000);
    let _wrapper = new mojs.Shape({
      parent: '.omini',
      className: 'wrapper-' + i,
      fill: 'none',
      radius: 0,
      top: _position + '%',
      left: 0
    });
    let _head = new mojs.Shape({
      parent: '.wrapper-' + i,
      className: 'omino man-head-' + i,
      shape: 'circle',
      radius: 6,
      fill: _color,
      top: _position + '%',
      // top: 0,
      left: 0,
      x: {
        1: 0
      },
      y: {
        '-1': 0
      },
      duration: _duration / 4,
      ...repeat
    });
    let _body = new mojs.Shape({
      parent: '.man-head-' + i,
      class: 'man-body-' + i,
      shape: 'line',
      stroke: _color,
      radius: 8,
      strokeWidth: 9,
      strokeLinecap: 'round',
      angle: {
        88 : 92
      },
      origin: 'center',
      x: {
        0: '-1'
      },
      y: {
        24: 23
      },
      duration: _duration / 2,
      ...repeat
    });
    let leg_shape_opts = {
      shape: 'line',
      radius: 6,
      stroke: _color,
      strokeWidth: 6,
      strokeLinecap: 'round',
      origin: '0% 50%',
      easing: 'sin.out',
      backwardEasing: 'sin.in',
      isShowStart: true,
      ...repeat
    };
    let leg_opts = {
      ...leg_shape_opts,
      y: 33,
      x: {
        9: 8
      },
      duration: _duration / 2
    };
    let leg_b_opts = {
      ...leg_shape_opts,
      x: 12,
      delay: _duration / 4,
      duration: _duration / 4
    };
    let _LegL = new mojs.Shape({
      ...leg_opts,
      parent: '.man-head-' + i,
      className: 'left-leg-' + i,
      angle: {
        75: 105
      }
    });
    let _LegLb = new mojs.Shape({
      ...leg_b_opts,
      parent: '.left-leg-' + i,
      y: {
        .6: 0
      },
      angle: {
        345: 360
      }
    });
    let _LegR = new mojs.Shape({
      ...leg_opts,
      parent: '.man-head-' + i,
      className: 'right-leg-' + i,
      angle: {
        105: 75
      }
    });
    let _LegRb = new mojs.Shape({
      ...leg_b_opts,
      parent: '.right-leg-' + i,
      y: {
        0: .6
      },
      angle: {
        360: 345
      }
    });
    let arm_shape_opts = {
      shape: 'line',
      strokeWidth: 5,
      strokeLinecap: 'round',
      stroke: _color,
      origin: '0% 50%',
      easing: 'sin.out',
      backwardEasing: 'sin.in',
      isShowStart: true,
      duration: _duration / 2,
      ...repeat
    };
    let _armL = new mojs.Shape({
      ...arm_shape_opts,
      parent: '.man-head-' + i,
      className: 'arm-left-' + i,
      radius: 5,
      angle: {
        65: 115
      },
      x: 7,
      y: 12
    });
    let _armLb = new mojs.Shape({
      ...arm_shape_opts,
      parent: '.arm-left-' + i,
      radius: 5.5,
      angle: {
        15: 40
      },
      x: 12,
      y: -1
    });
    let _armR = new mojs.Shape({
      ...arm_shape_opts,
      parent: '.man-head-' + i,
      className: 'arm-right-' + i,
      radius: 5,
      angle: {
        115: 65
      },
      x: 7,
      y: 12
    })
    let _armRb = new mojs.Shape({
      ...arm_shape_opts,
      parent: '.arm-right-' + i,
      radius: 5.5,
      angle: {
        40: 15
      },
      x: 12,
      y: -1
    });

    let arm = new mojs.Timeline().add(_armL, _armLb, _armR, _armRb);
    let legs = new mojs.Timeline().add(_LegL, _LegLb, _LegR, _LegRb);
    let man = new mojs.Timeline().add(_head, _body, arm, legs);

    return man;
  }

  this.generateLemmingBackward = function(i) {
    let _color = colors[Math.floor(Math.random() * n_colors)];
    let _position = -1.5 + (Math.floor((Math.random() * 100) + 1) / 100);
    let _duration = Math.floor((Math.random() * 2000) + 2000);
    let _wrapper = new mojs.Shape({
      parent: '.omini',
      className: 'wrapper-' + i,
      fill: 'none',
      radius: 1,
      top: _position + '%',
      left: 0
    });
    let _head = new mojs.Shape({
      parent: '.wrapper-' + i,
      className: 'omino man-head-' + i,
      shape: 'circle',
      radius: 6,
      fill: _color,
      top: _position + '%',
      left: 0,
      x: {
        0: 1
      },
      y: {
        0: -1
      },
      duration: _duration / 4,
      ...repeat
    });
    let _body = new mojs.Shape({
      parent: '.man-head-' + i,
      class: 'man-body-' + i,
      shape: 'line',
      stroke: _color,
      radius: 8,
      strokeWidth: 9,
      strokeLinecap: 'round',
      angle: {
        92 : 88
      },
      origin: 'center',
      x: {
        '-1': 0
      },
      y: {
        23: 24
      },
      duration: _duration / 2,
      ...repeat
    });
    let leg_shape_opts = {
      shape: 'line',
      radius: 6,
      stroke: _color,
      strokeWidth: 6,
      strokeLinecap: 'round',
      origin: '0% 50%',
      easing: 'sin.out',
      backwardEasing: 'sin.in',
      isShowStart: true,
      ...repeat
    };
    let leg_opts = {
      ...leg_shape_opts,
      y: 33,
      x: {
        8: 9
      },
      duration: _duration / 2
    };
    let leg_b_opts = {
      ...leg_shape_opts,
      x: 12,
      delay: _duration / 4,
      duration: _duration / 4
    };
    let _LegL = new mojs.Shape({
      ...leg_opts,
      parent: '.man-head-' + i,
      className: 'left-leg-' + i,
      angle: {
        75: 105
      }
    });
    let _LegLb = new mojs.Shape({
      ...leg_b_opts,
      parent: '.left-leg-' + i,
      y: {
        0: '-.6'
      },
      angle: {
        0: 15
      }
    });
    let _LegR = new mojs.Shape({
      ...leg_opts,
      parent: '.man-head-' + i,
      className: 'right-leg-' + i,
      angle: {
        105: 75
      }
    });
    let _LegRb = new mojs.Shape({
      ...leg_b_opts,
      parent: '.right-leg-' + i,
      y: {
        '-.4': 0
      },
      angle: {
        15: 0
      }
    });
    let arm_shape_opts = {
      shape: 'line',
      strokeWidth: 5,
      strokeLinecap: 'round',
      stroke: _color,
      origin: '0% 50%',
      easing: 'sin.out',
      backwardEasing: 'sin.in',
      isShowStart: true,
      duration: _duration / 2,
      ...repeat
    };
    let _armL = new mojs.Shape({
      ...arm_shape_opts,
      parent: '.man-head-' + i,
      className: 'arm-left-' + i,
      radius: 5,
      angle: {
        65: 125
      },
      x: 7,
      y: 12
    });
    let _armLb = new mojs.Shape({
      ...arm_shape_opts,
      parent: '.arm-left-' + i,
      radius: 5.5,
      angle: {
        325: 350
      },
      x: 12,
      y: {
        1: 0
      }
    });
    let _armR = new mojs.Shape({
      ...arm_shape_opts,
      parent: '.man-head-' + i,
      className: 'arm-right-' + i,
      radius: 5,
      angle: {
        125: 65
      },
      x: 7,
      y: 12
    })
    let _armRb = new mojs.Shape({
      ...arm_shape_opts,
      parent: '.arm-right-' + i,
      radius: 5.5,
      angle: {
        350: 325
      },
      x: 12,
      y: {
        0: 1
      }
    });

    let arm = new mojs.Timeline().add(_armL, _armLb, _armR, _armRb);
    let legs = new mojs.Timeline().add(_LegL, _LegLb, _LegR, _LegRb);
    let man = new mojs.Timeline().add(_head, _body, arm, legs);

    return man;
  }

  this.walks = function(_timeline, _direction, _path, index, shift) {
    // let name = '.man-head-'+i;
    // let object = document.querySelector(name);
    let _pathLenght = _path.getTotalLength();
    let _delay = Math.floor((Math.random() * walkDuration) + 1);
    let _walk = new mojs.Tween({
      duration: walkDuration,
      direction: _direction,
      delay: _delay,
      onUpdate(ep, p, isForward, isYoyo) {
        let v = _pathLenght * (p - 1) + _pathLenght;
        let w = $('#logo-img').outerWidth();
        let h = $('#logo-img').outerHeight();

        let point = _path.getPointAtLength(v);
        let startPoint = _path.getPointAtLength(0);
        let endPoint = _path.getPointAtLength(_pathLenght);

        let kx = w / 1920;
        let ky = h / 1080;
        let x = point.x * kx;
        let y = point.y * ky;
        let startX = startPoint.x * kx;
        let startY = startPoint.y * ky;
        let endX = endPoint.x * kx;
        let endY = endPoint.y * ky;
        let sx = manScale * (w / 1920) * (y / h);

        let _angle = 0;
        if (y < startY && y > endY) {
          _angle = angle;
        }

        let obj = new mojs.Html({
          el: '.wrapper-' + index,
          x: x,
          y: y,
          angleY: angle,
          scaleX: sx,
          scaleY: sx
        }).play();

        // rimuove gli omini quando arrivano a fine corsa o all'inizio se la direzione è inversa altrimenti li manda in play
        if (_direction == 1 && y == endY && x == endX) {
          _timeline.stop();
          _walk.reset();
          $('.wrapper-' + index).remove();
        } else if (_direction == -1 && y == startY && x == startX) {
          _timeline.stop();
          _walk.reset();
          $('.wrapper-' + index).remove();
        } else {
          _timeline.play();
        }
      },
      onPlaybackComplete() {
        _timeline.reset();
        _walk.reset();
        $('.wrapper-' + index).remove();
      }
    });
    if (_direction == 1) {
      _walk.play(shift);
    } else {
      // if (shift != 0) {
      //   shift = shift + walkDuration;
      // }
      _walk.playBackward(shift);
    }
  }

  this.goGoLemmmings = function(number, isStart) {
    console.log('Go Lemmings');
    for (var i = 0; i < number; i++) {
      let _pathIndex = Math.floor(Math.random() * n_paths);
      let direction = Math.random() >= 0.5;
      let timeline = null;
      let index = counter;

      // Assegno la direzione
      if (direction == false) {
        direction = -1;
      } else {
        direction = 1;
      }

      if (i < (number * leftStreet)) {
        while (paths[_pathIndex][1] == 'right') {
          _pathIndex = Math.floor(Math.random() * n_paths);
        }
      } else {
        while (paths[_pathIndex][1] == 'left') {
          _pathIndex = Math.floor(Math.random() * n_paths);
        }
      }

      let _pathDirection = paths[_pathIndex][0];
      let _pathSide = paths[_pathIndex][1];
      let _path = paths[_pathIndex][2];

      if (_pathDirection == 'left_to_right') {
        if (direction == -1) {
          timeline = this.generateLemming(index)
        } else {
          timeline = this.generateLemmingBackward(index)
        }
      } else if (_pathDirection == 'right_to_left') {
        if (direction == -1) {
          timeline = this.generateLemmingBackward(index)
        } else {
          timeline = this.generateLemming(index)
        }
      }

      if (isStart == true) {
        let shift = Math.floor((Math.random() * walkDuration) + 1);
        this.walks(timeline, direction, _path, index, shift);
      } else {
        this.walks(timeline, direction, _path, index, 0);
      }

      counter = counter + 1;

    }
  }
}

export default Lemming
