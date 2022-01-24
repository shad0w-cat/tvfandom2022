/**
 * The Sign-In client object.
 */
var auth2;

/**
 * Initializes the Sign-In client.
 */
var initClient = function () {
    gapi.load('auth2', function () {
        /**
         * Retrieve the singleton for the GoogleAuth library and set up the
         * client.
         */
        auth2 = gapi.auth2.init({
            client_id: '298897629681-u86dd9pq3hampuemvpnaeprlu7tm9ugm.apps.googleusercontent.com'
        });

        // Attach the click handler to the sign-in button
        auth2.attachClickHandler('signin-button', {}, onSuccess, onFailure);
    });
};

/**
 * Handle successful sign-ins.
 */
var onSuccess = function (user) {
    console.log('Signed in as ' + user.getBasicProfile().getName());
};

/**
 * Handle sign-in failures.
 */
var onFailure = function (error) {
    console.log(error);
};