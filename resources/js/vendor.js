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
        let mainChatInbox = $('.wsus__chat_area_body');
        let message = `                                              
            <div class="wsus__chat_single">
                <div class="wsus__chat_single_img">
                    <img src="${e.sender_image}"
                        alt="user" class="img-fluid">
                </div>
                <div class="wsus__chat_single_text">
                    <p>${e.message}</p>
                    <span>${formatDateTime(e.data_time)}</span>
                </div>
            </div>`

        mainChatInbox.append(message);
        scrollToButton();
    }
)
