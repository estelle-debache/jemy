/* globals wsUrl: true */
(function () {
    'use strict';

    var _receiver = document.getElementById('ws-content-receiver');
    console.log(_receiver);
    var ws = new WebSocket('ws://' + wsUrl);
    var defaultChannel = 'general';
    var botName = 'ChatBot';
    var userName = document.getElementById('username').innerText;
    var _textInput = document.getElementById('ws-content-to-send');
    var _textSender = document.getElementById('ws-send-content');
    var enterKeyCode = 13;

    var sendTextInputContent = function () {
        // Get text input content
        var content = _textInput.value;

        // Send it to WS
        ws.send(JSON.stringify({
            action: 'message',
            user: userName,
            message: content,
            channel: 'general'
        }));

        // Reset input
        _textInput.value = '';
    };

    _textSender.onclick = sendTextInputContent;
    _textInput.onkeyup = function (e) {
        // Check for Enter key
        if (e.keyCode === enterKeyCode) {
            sendTextInputContent();
        }
    };

    var addMessageToChannel = function (message) {
        // console.log(JSON.parse(message));
        var parsedMessage = JSON.parse(message);
        var myMessage = parsedMessage['message'];
        var myUser = parsedMessage['user'];

        _receiver.innerHTML += '<div class="message">' + myUser + 'dit:' + myMessage + '</div>';
    };

    var botMessageToGeneral = function (message) {
        return addMessageToChannel(JSON.stringify({
            action: 'message',
            channel: defaultChannel,
            user: botName,
            message: message
        }));
    };

    ws.onopen = function () {
        ws.send(JSON.stringify({
            action: 'subscribe',
            channel: defaultChannel,
            user: userName
        }));
    };

    ws.onmessage = function (event) {
        addMessageToChannel(event.data);
    };

    ws.onclose = function () {
        botMessageToGeneral('Connection closed');
    };

    ws.onerror = function () {
        botMessageToGeneral('An error occured!');
    };
})();