var today = today || {};

$(".chooseDay").delegate("li","click",function(){
	$(this).addClass('select').siblings().removeClass('select');
	for(var i=0;i<$("ul.chooseDay li").length;i++){
		
		if($("ul.chooseDay li").eq(i).hasClass("select")){
			$("ul.chooseDay li").eq(i).text($(this).attr("data-select"));
		}else{
			$("ul.chooseDay li").eq(i).text($("ul.chooseDay li").eq(i).attr("data-name"));
		}
	}
	today.gotoSelect();
});

today.gotoSelect=function(){
	var selectId=$(".chooseDay li.select").attr("data-type");
	if(selectId=="today"){
		$("html,body").animate({ scrollTop: 0  }, 1000);
	}else{
		$("html,body").animate({ scrollTop: $("."+selectId+"-content").offset().top  }, 1000);
	}
	
}
