 <table style="width:100%;">
	 <tbody>
	 <tr><td><?=submit_button( $text = 'Schedule Booking', $type = 'primary', $name = 'submit', $wrap = false, $other_attributes = NULL );?></td> 
	 <td><?="<a class='button button-primary' href='" . wp_nonce_url("/wp-admin/post.php?action=delete&amp;post=$post_ID", 'delete-post_' . $post_ID) . "'>Delete Booking</a>";?></td></tr>

	 </tbody>
	 </table>
	 <table style="width:100%;">
	 	 <tr>
	 <td>





	 </td>
	 </tr>
	 </table>