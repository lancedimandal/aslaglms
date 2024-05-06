var ByMTTListings = (function (jQuery) {
  var $ = jQuery;
  var self = false;

  $(function () {
    self.ready();
    try {
    } catch (error) {
      return;
    }
  });

  function redrawGrid() {
    let resizeHeight = $("body").height() + 175;
    //  $(window.parent.document).find('#By_iframe_result').css('height', resizeHeight );
  }

  /* returns required functions */
  return {
    init: function () {
      self = this;
    },

    ready: function () {
      self = this;

      $(".By_member_loopgrid .e-loop-item").each(function (index, val) {
        let currentPost = $(this);
        $(byronsMeetTeamData.memberData).each(function (mkey, mval) {
          if (currentPost.hasClass("post-" + mval.ID)) {
            currentPost.attr("data-bypostid", mval.ID);
            currentPost.attr("data-byslug", mval.slug);
            currentPost
              .find(".By_learnmore_pointer")
              .wrap(
                `<a title="team member" class="By-click-pointer" href="${mval.slug}" ></a>`
              );
          }
        });
      });

      $(".By_member_loopgrid .e-loop-item .fa-long-arrow-right").on(
        "click",
        function (event) {
          event.preventDefault(); // Prevent the default behavior of anchor tag
          let postid = $(this).parents(".e-loop-item").data("byslug");
          window.parent.location.href = postid; // Use the anchor tag's href attribute
        }
      );

      //             $('.By_member_loopgrid .e-loop-item .fa-long-arrow-right').on('click',function(){
      //                 let postid = $(this).parents('.e-loop-item').data('byslug');
      //                 window.parent.location.href = ( postid );
      //             });

      $(window).resize(function () {
        redrawGrid();
      });

      redrawGrid();
    },
  };
})(jQuery);

ByMTTListings.init();
