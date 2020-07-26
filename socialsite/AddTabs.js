if(typeof($add)=="undefined")var $add={version:{},auto:{disabled:false}};(function($){
  $add.version.Tabs = "1.1.0";
  $add.Tabs = function(selector, settings){
    $(selector).each(function(i, el){
      var $el = $(el);
      var S = $.extend({
        change: "click"
      }, $el.data(), settings);
      var $tabHolder = $el.find("[role=tabs]");
      $tabHolder.addClass("addui-Tabs-tabHolder");
      var $tabs = $tabHolder.children();
      var $contentHolder = $el.find("[role=contents]");
      $contentHolder.addClass("addui-Tabs-contentHolder");
      var $contents = $contentHolder.children();
      var active = 0;
      $el.addClass("addui-Tabs").attr("role", "").removeAttr("role");
      $tabs.addClass("addui-Tabs-tab");
      $contents.addClass("addui-Tabs-content").each(function(i, c){
        if($(c).hasClass("active")){
          $(c).removeClass("active");
          active = i;
        }
      });
      $contents.removeClass("addui-Tabs-active").eq(active).addClass("addui-Tabs-active");
      $tabs.removeClass("addui-Tabs-active").eq(active).addClass("addui-Tabs-active");
      var event = "click";
      if(S.change == "hover") event = "mouseenter";
      $tabs.on(event, function(e){
        $tabs.each(function(i, t){
          if(t == e.target){
            active = i;
            $contents.removeClass("addui-Tabs-active").eq(active).addClass("addui-Tabs-active");
            $tabs.removeClass("addui-Tabs-active").eq(active).addClass("addui-Tabs-active");
          }
        });
      })
    });
    return this;
  };
  $.fn.addTabs = function(settings){
    $add.Tabs(this, settings);
  };
  $add.auto.Tabs = function(){
    if(!$add.auto.disabled){
      $("[data-addui=tabs]").addTabs();
    }
  }
})(jQuery);
$(function(){for(var k in $add.auto){if(typeof($add.auto[k])=="function"){$add.auto[k]();}}});