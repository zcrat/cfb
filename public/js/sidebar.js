
$(function() {
    let s1 = $('.msidebar');
    let s2 = $('.msidebar-links');
    let s3 = $('.body-container');
    $('#sider , .contraer').on('click', function() {
        s1.toggleClass('active-sidebar');
        s2.toggleClass('active-msidebar-links');
        s3.toggleClass('active-body-container');
    });
});
