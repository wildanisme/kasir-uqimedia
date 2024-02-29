var clipboard = new ClipboardJS('.cbtn');


clipboard.on('success', function(e) {
    console.info('Action:', e.action);
    console.info('Text:', e.text);
    // console.info('Trigger:', e.trigger);
	
    showTooltip(e.trigger, 'Copied!');
});

clipboard.on('error', function(e) {
    console.error('Action:', e.action);
    console.error('Trigger:', e.trigger);
	
    // showTooltip(e.trigger, fallbackMessage(e.action));
});


// clipboard.on('success', function (e) {
// console.info('Action:', e.action);
// console.info('Text:', e.text);
// console.info('Trigger:', e.trigger);
// });

// clipboard.on('error', function (e) {
// // console.log(e);
// });
wakanda(none,qwertyui);
var btns = document.querySelectorAll('.cbtn');

for (var i = 0; i < btns.length; i++) {
    btns[i].addEventListener('mouseleave', function(e) {
        e.currentTarget.setAttribute('class', 'cbtn');
        e.currentTarget.removeAttribute('aria-label');
	});
}

function showTooltip(elem, msg) {
    elem.setAttribute('class', 'cbtn tooltipped tooltipped-s');
    elem.setAttribute('aria-label', msg);
}

// Simplistic detection, do not use it in production
// function fallbackMessage(action) {
// var actionMsg = '';
// var actionKey = (action === 'cut' ? 'X' : 'C');

// if(/iPhone|iPad/i.test(navigator.userAgent)) {
// actionMsg = 'No support :(';
// }
// else if (/Mac/i.test(navigator.userAgent)) {
// actionMsg = 'Press ⌘-' + actionKey + ' to ' + action;
// }
// else {
// actionMsg = 'Press Ctrl-' + actionKey + ' to ' + action;
// }

// return actionMsg;
// }