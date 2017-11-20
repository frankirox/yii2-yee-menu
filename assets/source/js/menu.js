$(document).ready(function() {

    $('.menu-box .menu-list').sortable({
        connectWith: '.menu-list',
        tolerance: 'intersect',
        delay: 250,
        stop: function(event, ui) {
            var orders = [];

            $(".menu-box .menu-link > div").each(function(index, element) {
                $(element).find('.order').text(index);
                var id = $(this).data('link-id');
                var parent = $(this).closest('.menu-list').data('parent-id');
                parent = (parent.length === 0) ? null : parent;
                orders.push({id: id, order: index, parent: parent});
            });


            console.log(orders);
            $.ajax({
                type: "POST",
                url: '/admin/menu/default/save-orders',
                data: {orders: orders},
                success: function(data){
                    Notification.showSuccess('The changes have been saved.');
                },
                error: function(data){
                    Notification.showError('An error occurred during saving menu!');
                },
            });
        },
    });

});