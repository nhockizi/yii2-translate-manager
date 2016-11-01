$(document).ready(function() {
    Language.init();
});

var Language = {
    init: function() {
        $('#languages').on('change', 'select.status', $.proxy(function(event) {
            this.changeStatus($(event.currentTarget));
        }, this));
    },
    /**
     * Change language status.
     * @param {object} $object
     */
    changeStatus: function($object) {
        var $data = {
            language_id: $object.attr('id'),
            status: $object.val()
        };
        helpers.post($object.data('url'), $data);
    }
};