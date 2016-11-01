var nhockizi = (function () {

    return {
        
        t: function (message, $params) {
            if (
                    typeof (languageItems) !== 'undefined' &&
                    typeof (language) !== 'undefined' &&
                    typeof (languageItems[language]) !== 'undefined' &&
                    typeof (languageItems[language].getLanguageItems) === 'function') {
                var $messages = languageItems[language].getLanguageItems();
                if (typeof ($messages) !== 'undefined') {
                    var hash = md5(message);
                    if (typeof ($messages[hash]) !== 'undefined') {
                        message = $messages[hash];
                    }
                }
            }

            if (typeof ($params) !== 'undefined') {
                for (search in $params) {
                    message = message.replace('{' + search + '}', $params[search]);
                }
            }

            return message;
        }
    };
})();

