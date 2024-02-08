document.addEventListener("DOMContentLoaded", function() {
  document.querySelectorAll('.content__item').forEach(function(contentItem) {
    var postId = contentItem.dataset.postId;
    var likeButton = contentItem.querySelector('.plus');
    var dislikeButton = contentItem.querySelector('.minus');
    var likesCount = contentItem.querySelector('.good');

    likeButton.addEventListener('click', function() {
      handleVote(postId, 1, likesCount, likeButton, dislikeButton);
    });

    dislikeButton.addEventListener('click', function() {
      handleVote(postId, 0, likesCount, likeButton, dislikeButton);
    });

    var voteState = JSON.parse(localStorage.getItem('voteState_' + postId));
    if (voteState) {
      likeButton.disabled = voteState.likeButtonDisabled;
      dislikeButton.disabled = voteState.dislikeButtonDisabled;
    }
  });
});

function handleVote(postId, voteType, likesCount, likeButton, dislikeButton) {
  var formData = new FormData();
  formData.append('action', 'handle_like_vote');
  formData.append('post_id', postId);
  formData.append('vote_type', voteType);

  fetch('/wp-admin/admin-ajax.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    console.log(data); 
    if (data.success) {

      likesCount.textContent = data.data.likes_count;

      likeButton.disabled = data.data.like_disabled;

      // Проверяем, можно ли нажимать кнопку дизлайка
      dislikeButton.disabled = data.data.dislike_disabled;

      var voteState = {
        likeButtonDisabled: likeButton.disabled,
        dislikeButtonDisabled: dislikeButton.disabled
      };
      localStorage.setItem('voteState_' + postId, JSON.stringify(voteState));
    } else {
      console.error('Ошибка:', data.message);
    }
  })
  .catch(error => console.error('Ошибка:', error));
}
