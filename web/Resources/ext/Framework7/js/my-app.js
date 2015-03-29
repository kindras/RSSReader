// Initialize your app
var myApp = new Framework7({
    pushState: true,
    cache: false,
    // Hide and show indicator during ajax requests
    onAjaxStart: function (xhr) {
        myApp.showIndicator();
    },
    onAjaxComplete: function (xhr) {
        myApp.hideIndicator();
    }
});

// Export selectors engine
var $$ = Dom7;

// Add view
var mainView = myApp.addView('.view-main', {
    // Because we use fixed-through navbar we can enable dynamic navbar
    dynamicNavbar: true,
    allowDuplicateUrls: true
});

myApp.onPageInit('manageFeeds', function (page) {
    $$('.swipeout').on('deleted', function () {
        $$.ajax({
            url: '/app.php/feeds/' + $$(this).attr('data-id'),
            method: 'DELETE',
            success: function (data, status, xhr) {
                result = JSON.parse(data);
                myApp.alert(result.message, 'Remove feed', function ()
                {
                    if (result.status === 200)
                    {
                        mainView.router.loadPage('/app.php/feeds/manage');
                    }
                });
            }
        });
    });
});

popupAlreadyDefined = false;
function initPopupAddFeed()
{
    $$('.open-addFeed').on('click', function () {
        myApp.popup('.popup-addFeed');

        $$('.popup-addFeed').on('opened', function () {
            if (!popupAlreadyDefined)
            {
                popupAlreadyDefined = true;
                $$('.popup-addFeed form').on('submit', function (event) {
                    $$.ajax({
                        url: '/app.php/feeds/subscribe',
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function (data, status, xhr) {
                            result = JSON.parse(data);
                            myApp.alert(result.message, 'Add feed', function ()
                            {
                                if (result.status === 201)
                                {
                                    myApp.closeModal('.popup-addFeed');
                                    mainView.router.loadPage('/app.php/feeds/' + result.feedId);
                                }
                            });
                        }
                    });

                    event.preventDefault()
                    return false;
                });
            }
        });
    });
}

function initRefreshButton()
{
    $$('a.refresh').on('click', function (event) {
        $$.ajax({
            url: '/app.php/feeds/refresh/' + $$(this).attr('data-id'),
            method: 'PUT',
            data: $(this).serialize(),
            success: function (data, status, xhr) {
                result = JSON.parse(data);
                if (result.status === 200)
                {
                    mainView.router.loadPage('/app.php/feeds/' + result.feedId);
                }
                else
                {
                    myApp.alert(result.message, 'Error');
                }
            }
        });
    });
}

myApp.onPageInit('entry', function (page) {
    $$('.page-content .entry a').addClass('external').attr('target', '_blank');
});

myApp.onPageInit('*', function (page) {
    $$('.open-addFeed').on('click', function () {
        myApp.popup('.popup-addFeed');
    });
});

myApp.onPageBeforeAnimation('*', function (page) {
    initPopupAddFeed();
    initRefreshButton();
});

initPopupAddFeed();
initRefreshButton();
