
 <?php 
include("../Main/database.php");
?>
<main class="userIndex" style="">
 	<div id="allPost" style="width: 65%">
		<br><br>
		 <input type="hidden" id="is_active_post_window" value="no" />
		<div id="all_post_history" style="width: 90%;"><?php  ?>
			</div>
		<div id="user_post_details"></div>
	</div>
	<div id="user_list_details;" style="width: 35%;">
		<br><br><br>
		<div id="fetchUserList" style="width: 100%;    border: 1px  solid black; border-radius: 5px; background: lightgrey;">
            <h3 class="panel-title" style="background: grey">User List</h3>
                    <div id="user_list"></div>
             </div>
	</div>
                
</main>

<style type="text/css">
	/*when the width of browser is less than 1000px */
	@media (max-width: 1000px)
	{
	#allPost{
		width: 100%;
		}
	#user_list_details{
		display: none;
	}
	#fetchUserList{
		display: none;
	}
	}
</style>


<script>
  	$(document).ready(function(){
		$('#is_active_post_window').val('yes');
  		fetch_all_post_history();
  		fetch_post_comment_history();
  		
  		//this will refresh the page without loading the page.
  		setInterval(function(){
  		update_post_history_data();
  		// fetch_all_post_history();
  		fetch_post_comment_history();
  		fetch_user();
		 }, 5000);


  	fetch_user();

    function fetch_user()
    {
        var action = 'fetch_user';
        $.ajax({
            url:"../Include/action.php",
            method:"POST",
            data:{action:action},
            success:function(data)
            {
                $('#user_list').html(data);
            }
        });
    }

    $(document).on('click', '.action_button', function(){
        var sender_id = $(this).data('sender_id');
        var action = $(this).data('action');
        $.ajax({
            url:"../Include/action.php",
            method:"POST",
            data:{sender_id:sender_id, action:action},
            success:function(data)
            {
                fetch_user();
                // fetch_post();
            }
        })
    });

// this function will show the chat box.
		function make_post_dialog_box(to_post_id, to_user_name)
		{
			var modal_content = '<div id= "post_dialog_'+to_post_id+'" class = "post_dialog" title="Comment on this post.">';
			modal_content += '<div class = "form-group">';

			modal_content += '<textarea name = "post_comment_'+to_post_id+'" id = "post_comment_'+to_post_id+'" class="form-control chat_message"></textarea>';

			modal_content += '</div><div class = "form-group" align ="right">';

			modal_content+= '<input type="hidden" name="comment_id" id="comment_id" value="0"><button type="button" name="send_comment" id="'+to_post_id+'" class="btn btn-info send_comment">Comment</button></div>';

			modal_content += '<div style="height: 300px; border:1px solid #ccc; overflow-y: scroll; margin-bottom: 24px; padding:16px;" class="post_history" data-topostid = "'+to_post_id+'" id="post_history_'+to_post_id+'">';
			
			modal_content += fetch_post_comment_history(to_post_id);

			modal_content += '</div></div>';

			$('#user_post_details').html(modal_content);
		}
			
		$(document).on('click', '.comment', function(){
			var to_post_id = $(this).data('topostid');
			var to_user_name = $(this).data('tousername');
			make_post_dialog_box(to_post_id, to_user_name);
			$("#post_dialog_"+to_post_id).dialog({
				autoOpen:false,
				width:500
			});
			$('#post_dialog_'+to_post_id).dialog('open');
			$('#post_comment_'+to_post_id).emojioneArea({
				pickerPosition : "bottom",
				toneStyle: "bullet"
			});
		});

		$(document).on('click', '.send_comment', function(){
			var to_post_id = $(this).attr('id');
			var chat_message = $('#post_comment_'+to_post_id).val();
			$.ajax({
				url: "../Include/insert_comment.php",
				method: "POST",
				data: {to_post_id:to_post_id, chat_message:chat_message},
				success:function(data)
				{
					var element = $('#post_comment_'+to_post_id).emojioneArea();
					element[0].emojioneArea.setText('');
					$('#post_history_'+to_post_id).html(data);
				}

			})
		});

		$(document).on('click', '.likeAction_button', function(){
        var post_id = $(this).data('post_id');
        var action = $(this).data('action');
        $.ajax({
            url:"../Include/likeAction.php",
            method:"POST",
            data:{post_id:post_id, action:action},
            success:function(data)
            {
                fetch_all_post_history();//self reload the page.
            }
        })
    });

		$(document).on('click', '.deleteAction_button', function(){
        var post_id = $(this).data('post_id');
        var action = $(this).data('action');

        $.ajax({
            url:"../profile/delete_post.php",
            method:"POST",
            data:{post_id:post_id, action:action},
            success:function(data)
            {
                fetch_all_post_history();//self reload the page.
            }
        })
    });
	



		function fetch_post_comment_history(to_post_id)
		{
			$.ajax({
				url: "../Include/fetch_post_comment_history.php",
				method: "POST",
				data: {to_post_id:to_post_id},
				success:function(data){
					$('#post_history_'+to_post_id).html(data);
				}
			})
		}

		function update_post_history_data()
		{
			$('.post_history').each(function(){
				var to_post_id = $(this).data('topostid');
				fetch_post_comment_history(to_post_id);
			});
		}

		function fetch_all_post_history()
		{
			var post_dialog_activity = $('#is_active_post_window').val();
			var action = "fetch_data";
			if (post_dialog_activity == 'yes') 
			{
				$.ajax({
					url: "../include/fetchPost.php",
					method: "POST",
					data:{action:action},
					success:function(data)
					{
						$('#all_post_history').html(data);
					}
				})
			}
		}

  	});
  </script>