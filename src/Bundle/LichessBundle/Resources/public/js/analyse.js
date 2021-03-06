jQuery(function() {
	SetImagePath("/vendor/pgn4web/lichess/64"); // use "" path if images are in the same folder as this javascript file
	SetImageType("png");
	setTimeout(function() {
		SetAutoplayDelay(2000);
		SetAutoPlay(true);
	},
	1000);
});

function customFunctionOnPgnGameLoad() {
    var $text = $('#ShowPgnText');
    var html = '<table><tbody><tr>';
	$text.find('span.move').remove();
    $text.find('>span').each(function(it) {
        if (0 == it%2) {
            html += '</tr><tr><th>' + (it/2+1) + '.</th>';
        }
        html += '<td>' + this.innerHTML + '</td>';
    });
    html += '</tr></tbody></table>';
    $text.html(html).find('tr:empty').remove();

	$('div.lichess_goodies a.rotate_board').click(function() {
		$('#GameBoard').toggleClass('flip');
        $('#player_links div:first').appendTo($('#player_links'));
		redrawBoardMarks();
		return false;
	});
	redrawBoardMarks();
}

function redrawBoardMarks() {
	jQuery.displayBoardMarks($('#GameBoard'), ! $('#GameBoard').hasClass('flip'));
}
