<div class="box" id="searhHistoryBox" style="display:none;">
  <div class="box-heading"><?php echo $heading_title; ?></div>

  <div class="box-content" id="recentSearches">
  </div>
</div>

<script>
  function clearSearhHistory(){
	localStorage.removeItem('searhHistory');
	$('#searhHistoryBox').fadeOut();	
	return false;
  }
  
  if(!Storage.setObject){
    Storage.prototype.setObject = function(key, obj) {
        return this.setItem(key, JSON.stringify(obj))
    }
  }
  if(!Storage.getObject){
    Storage.prototype.getObject = function(key) {
        return JSON.parse(this.getItem(key))
    }
  }
  
	if(localStorage.getObject('searhHistory') != null){
		var searhHistory = localStorage.getObject('searhHistory');
		
		var searhHistoryContent = '<ul style="list-style: none outside none;margin:5px 2px;padding:1px;">';
		if(searhHistory.length > 0) { 
			jQuery.each(searhHistory, function() {
			  searhHistoryContent +='<li><a href="<?php echo $link_search_url; ?>' + this + '">' + this + '</a></li>';
			});
		   
			if(searhHistory.length > 0) 
				searhHistoryContent += '<li style="float:right">[<a onclick="clearSearhHistory();"><?php echo $text_clear_recent_searches; ?></a>]</li>';
				
			searhHistoryContent += '</ul>';
			$('#recentSearches').html(searhHistoryContent);
			$("#searhHistoryBox").show();
		
		}
	}	
  </script>