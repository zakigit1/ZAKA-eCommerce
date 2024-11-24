// function to costum the time : 
function formatDateTime(dateTimeString) {
    const options = {
        year: 'numeric',
        month: 'short',// like : November = Nov
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        // hour12: false 
        };

    const formatedDateTime = new Intl.DateTimeFormat('en-US', options).format(new Date(dateTimeString));

    return formatedDateTime;
}

// scrolling the conversion to button automatically when you click to the bull
function scrollToButton() {
    mainChatInbox.scrollTop(mainChatInbox.prop("scrollHeight"));
}

// listen to new message (realtime)
window.Echo.private('message.'+ USER.id).listen(
    'MessageEvent',//Event name.
    (e) => {
        console.log(e);
        let mainChatInbox = $('.chat-content');

        let message = `                                              
            <div class="chat-item chat-left" style="">
                <img src="${e.sender_image}" style="height: 50px;object-fit: cover">
                <div class="chat-details">
                    <div class="chat-text">${e.message}</div>
                    <div class="chat-time">${formatDateTime(e.data_time)}</div>
                </div>
            </div>`

        mainChatInbox.append(message);
        scrollToButton();
    }
)
