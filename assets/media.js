var frame;
(function ($) {
  $("#ocl_upload_image").on("click", function (e) {
    e.preventDefault();

    frame = wp.media({
      title: "Select Image",
      button: {
        text: "Insert Image",
      },
      multiple: false,
    });
    frame.on("select", function () {
      var attachment = frame.state().get("selection").first().toJSON();
      $(".ocl_upload_image").val(attachment.sizes.thumbnail.url);
      $("#ocl-logo-image").attr("src", attachment.sizes.thumbnail.url);
    });
    frame.open();
    return false;
  });
})(jQuery);
