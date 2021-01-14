/** Post Detail Pop Up */
$(document).on('click', '.post-detail', function () {
  let title = $(this).attr('data-title');
  let description = $(this).attr('data-description');
  let status = $(this).attr('data-status');
  let postedUser = $(this).attr('data-posted-user');
  let postedDate = $(this).attr('data-posted-date');
  let updatedDate = $(this).attr('data-updated-date');

  $('#detailTitle').text(title);
  $('#detailDescription').text(description);
  if(status == 0) {
    $('#detailStatus').text("Inactive").css('color', 'red');
  } else {
    $('#detailStatus').text("Active").css('color', 'green');
  }
  $('#detailPostedUser').text(postedUser);
  $('#detailPostedDate').text(postedDate);
  $('#detailUpdatedDate').text(updatedDate);
  $('#postDetailModal').modal('show');
});

/** Confirm Delete Form Data */
$(document).on('click', '.post-delete', function () {
  let postId = $(this).attr('data-deletePostId');
  $('#deletePostId').val(postId);
  $('#deletePostModal').modal('show');
});