QUnit.module('fabric.Observable');

QUnit.test('fabric.Observable exists', function(assert) {
  assert.ok(fabric.Observable);
  assert.ok(fabric.Observable.fire);
  assert.ok(fabric.Observable.on);
  assert.ok(fabric.Observable.once);
  assert.ok(fabric.Observable.off);
});

QUnit.test('fire + on', function(assert) {
  var foo = { };
  fabric.util.object.extend(foo, fabric.Observable);

  var eventFired = false;
  foo.on('bar:baz', function(  ) {
    eventFired = true;
  });

  foo.fire('bar:baz');
  assert.equal(eventFired, true);
});

QUnit.test('fire once', function (assert) {
  var foo = {};
  fabric.util.object.extend(foo, fabric.Observable);

  var eventFired = 0;
  foo.once('bar:baz', function () {
    assert.equal(this, foo);
    eventFired++;
  });

  foo.fire('bar:baz');
  assert.equal(eventFired, 1);
  foo.fire('bar:baz');
  assert.equal(eventFired, 1);
});

QUnit.test('fire once multiple handlers', function (assert) {
  var foo = {};
  fabric.util.object.extend(foo, fabric.Observable);
  var eventFired = 0;
  var eventFired2 = 0;
  var eventFired3 = 0;
  var eventData = { a: 'b', c: 'd' };
  foo.once({
    'bar:baz': function () {
      eventFired++;
      assert.equal(this, foo);
    },
    'blah:blah': function () {
      eventFired2++;
      assert.equal(this, foo);
    },
    'blah:blah:bloo': function (e) {
      eventFired3++;
      assert.equal(this, foo);
      assert.deepEqual(arguments[0], eventData);
      assert.equal(e, eventData);
    }
  });
  foo.fire('bar:baz');
  assert.equal(eventFired, 1);
  assert.equal(eventFired2, 0);
  foo.fire('blah:blah');
  assert.equal(eventFired, 1);
  assert.equal(eventFired2, 1);
  foo.fire('bar:baz');
  foo.fire('blah:blah');
  assert.equal(eventFired, 1);
  assert.equal(eventFired2, 1);
  assert.equal(eventFired3, 0);
  foo.fire('blah:blah:bloo', eventData);
});

QUnit.test('off', function(assert) {
  var foo = { };
  fabric.util.object.extend(foo, fabric.Observable);

  var eventFired = false;
  var handler = function() {
    eventFired = true;
  };
  foo.on('bar:baz', handler);
  foo.off('bar:baz', handler);

  foo.fire('bar:baz');
  assert.equal(eventFired, false);
});

QUnit.test('off without handler', function(assert) {
  var foo = { };
  fabric.util.object.extend(foo, fabric.Observable);

  var eventFired = false, event2Fired = false;

  var handler = function() {
    eventFired = true;
  };
  var handler2 = function() {
    event2Fired = true;
  };
  foo.on('bar:baz', handler);
  foo.on('bar:baz', handler2);

  foo.off('bar:baz');

  foo.fire('bar:baz');
  assert.equal(eventFired, false);
  assert.equal(event2Fired, false);

  foo.on('bar:baz', handler);
  foo.on('bar:baz', handler2);

  foo.off({'bar:baz': null});

  foo.fire('bar:baz');
  assert.equal(eventFired, false);
  assert.equal(event2Fired, false);
});

QUnit.test('off multiple handlers', function(assert) {
  var foo = { };
  fabric.util.object.extend(foo, fabric.Observable);

  var eventFired = false, event2Fired = false;

  var handler = function() {
    eventFired = true;
  };
  var handler2 = function() {
    event2Fired = true;
  };
  foo.on({'bar:baz': handler, 'blah:blah': handler2});

  foo.off({'bar:baz': handler, 'blah:blah': handler2});

  foo.fire('bar:baz');
  assert.equal(eventFired, false);
  foo.fire('blah:blah');
  assert.equal(event2Fired, false);
});

QUnit.test('off all events', function(assert) {
  var foo = { };
  fabric.util.object.extend(foo, fabric.Observable);

  var eventFired = false, event2Fired = false;

  var handler = function() {
    eventFired = true;
  };
  var handler2 = function() {
    event2Fired = true;
  };
  foo.on({'bar:baz': handler, 'blah:blah': handler2});

  foo.off();

  foo.fire('bar:baz');
  assert.equal(eventFired, false);
  foo.fire('blah:blah');
  assert.equal(event2Fired, false);
});

QUnit.test('on multiple handlers', function(assert) {
  var foo = { };
  fabric.util.object.extend(foo, fabric.Observable);

  var barBazFired = false;
  var blahBlahFired = false;
  var mooFired = false;

  foo.on({
    'bar:baz': function() {
      barBazFired = true;
    },
    'blah:blah': function() {
      blahBlahFired = true;
    },
    'moo': function() {
      mooFired = true;
    }
  });

  foo.fire('bar:baz');
  foo.fire('blah:blah');
  foo.fire('moo');

  assert.equal(barBazFired, true);
  assert.equal(blahBlahFired, true);
  assert.equal(mooFired, true);
});

QUnit.test('event options', function(assert) {
  var foo = { };
  fabric.util.object.extend(foo, fabric.Observable);

  var someValue;
  foo.on('foo:bar', function(e) {
    someValue = e.value;
  });

  foo.fire('foo:bar', { value: 'sekret' });

  assert.equal(someValue, 'sekret');
});

QUnit.test('fire', function(assert) {
  var foo = { };
  fabric.util.object.extend(foo, fabric.Observable);

  var eventFired = false;
  var context;
  foo.on('bar:baz', function() {
    context = this;
    eventFired = true;
  });

  foo.fire('bar:baz');
  assert.equal(eventFired, true);
  assert.equal(context, foo);
});

QUnit.test('removal of past events', function(assert) {
  var foo = { },
      event1Fired = false, event2Fired = false,
      event3Fired = false, event4Fired = false,
      handler1 = function() {
        event1Fired = true;
        foo.off('bar:baz', handler1);
      },
      handler2 = function() {
        event2Fired = true;
      },
      handler3 = function() {
        event3Fired = true;
      },
      handler4 = function() {
        event4Fired = true;
      };

  fabric.util.object.extend(foo, fabric.Observable);
  foo.on('bar:baz', handler1);
  foo.on('bar:baz', handler2);
  foo.on('bar:baz', handler3);
  foo.on('bar:baz', handler4);
  assert.equal(foo.__eventListeners['bar:baz'].length, 4, 'There should be 4 events registered now');
  foo.fire('bar:baz');
  assert.equal(foo.__eventListeners['bar:baz'].length, 3, 'There should be 3 events registered now');
  assert.equal(event1Fired, true, 'Event 1 should fire');
  assert.equal(event2Fired, true, 'Event 2 should fire');
  assert.equal(event3Fired, true, 'Event 3 should fire');
  assert.equal(event4Fired, true, 'Event 4 should fire');
});

QUnit.test('removal of past events inner loop', function(assert) {
  var foo = { },
      event1Fired = 0, event2Fired = 0,
      event3Fired = 0, event4Fired = 0,
      handler1 = function() {
        event1Fired++;
        foo.off('bar:baz', handler1);
        assert.equal(foo.__eventListeners['bar:baz'].length, 4, 'There should be still 4 handlers registered');
        assert.equal(event1Fired, 1, 'Event 1 should fire once');
        assert.equal(event2Fired, 0, 'Event 2 should not be fired yet');
        assert.equal(event3Fired, 0, 'Event 3 should not be fired yet');
        assert.equal(event4Fired, 0, 'Event 4 should not be fired yet');
        foo.fire('bar:baz');
        assert.equal(foo.__eventListeners['bar:baz'].length, 3, 'There should be 3 handlers registered now');
      },
      handler2 = function() {
        event2Fired++;
      },
      handler3 = function() {
        event3Fired++;
      },
      handler4 = function() {
        event4Fired++;
      };

  fabric.util.object.extend(foo, fabric.Observable);
  foo.on('bar:baz', handler1);
  foo.on('bar:baz', handler2);
  foo.on('bar:baz', handler3);
  foo.on('bar:baz', handler4);
  foo.fire('bar:baz');
  assert.equal(event1Fired, 1, 'Event 1 should fire once');
  assert.equal(event2Fired, 2, 'Event 2 should fire twice');
  assert.equal(event3Fired, 2, 'Event 3 should fire twice');
  assert.equal(event4Fired, 2, 'Event 4 should fire twice');
});

QUnit.test('adding events', function(assert) {
  var foo = { },
      event1Fired = false, event2Fired = false,
      event3Fired = false, event4Fired = false,
      handler1 = function() {
        event1Fired = true;
        foo.off('bar:baz', handler1);
        foo.on('bar:baz', handler3);
        foo.on('bar:baz', handler4);
      },
      handler2 = function() {
        event2Fired = true;
      },
      handler3 = function() {
        event3Fired = true;
      },
      handler4 = function() {
        event4Fired = true;
      };

  fabric.util.object.extend(foo, fabric.Observable);
  foo.on('bar:baz', handler1);
  foo.on('bar:baz', handler2);
  foo.fire('bar:baz');
  assert.equal(event1Fired, true, 'Event 1 should fire');
  assert.equal(event2Fired, true, 'Event 2 should fire');
  assert.equal(event3Fired, false, 'Event 3 should not fire');
  assert.equal(event4Fired, false, 'Event 4 should not fire');
  foo.fire('bar:baz');
  assert.equal(event3Fired, true, 'Event 3 should be fireed now');
  assert.equal(event4Fired, true, 'Event 4 should be fireed now');
});


QUnit.test('chaining', function(assert) {
  var foo = { };
  fabric.util.object.extend(foo, fabric.Observable);

  var event1Fired = false, event2Fired = false;
  foo
    .on('event1', function() {
      event1Fired = true;
    })
    .on('event2', function() {
      event2Fired = true;
    });

  foo.fire('event2').fire('event1');

  assert.equal(event1Fired, true);
  assert.equal(event2Fired, true);

  event1Fired = false;
  event2Fired = false;

  foo.off('event1').off('event2');
  foo.fire('event2').fire('event1');

  assert.equal(event1Fired, false);
  assert.equal(event2Fired, false);
});
