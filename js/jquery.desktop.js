//
// Kick things off.
//
jQuery(document).ready(function() {
	JQD.go();

});
//下面的链接先注释掉
var comNamess = [  
	//对应index.html的orderr 序号
	["http://www.baidu.com"], //0   这一个是左下角菜单:编程
	["http://122.144.216.14/test/1014/shkjw_left.html"], //1  仪电云
	["http://122.144.216.14/test/1014/zhzz_left.html"], //2 智能制造
	["http://122.144.216.14/test/1014/zhld_main.html"], //3	智能路灯网
	["http://122.144.216.14/test/1014/zhsy_left.html"], //4	智慧溯源  
	["http://122.144.216.14/test/1014/tcc_main.html"], //5	智慧交通
	["http://122.144.216.14/test/1014/ydxs_left.html"], //6	智慧教育
	["http://122.144.216.14/wqms"], //7	智慧水务
	["http://122.144.216.14/slim"],  //8	智能建筑
	["http://122.144.216.14/test/1014/hxgf_main.html"],  //9	商务不动产
	["http://122.144.216.14/test/1014/hxzq_main.html"], //10	非银行金融
	
	["http://122.144.216.14/test/1014/shkjw_left.html"], //11	数据中心  
	["http://122.144.216.14/test/1014/sckj_main.html"], //12	双创空间
	
	["http://122.144.216.14/test/1014/taopu_main.html"],  //13  桃浦区域地图
	
	["http://122.144.216.14/test/1014/jzy_main.html"],  //14  九州云
	["#"],  //15 sxky
	
	["http://122.144.216.14:1337"],//16桃浦科技智慧城管理系统点击
	["http://122.144.216.4:8181/monitor/site/login.jsp"]//17 重庆两江地图点击
	
];
// Namespace - Module Pattern.
//
var JQD = (function($, window, undefined) {
	// Expose innards of JQD.
	return {
		go: function() {
			for(var i in JQD.init) {
				JQD.init[i]();
			}
		},
		init: {
			frame_breaker: function() {
				if(window.location !== window.top.location) {
					window.top.location = window.location;
				}
//				注意:上面三句是iframe的防嵌套代码,加上此代码的话,比如百度统计热力图就不能使用
			},
			//
			// Initialize the clock.
			//
			clock: function() {
				if(!$('#clock').length) {
					return;
				}

				// Date variables.
				var date_obj = new Date();
				var hour = date_obj.getHours();
				var minute = date_obj.getMinutes();
				var day = date_obj.getDate();
				var year = date_obj.getFullYear();
				var suffix = 'AM';

				// Array for weekday.
				var weekday = [
					'Sunday',
					'Monday',
					'Tuesday',
					'Wednesday',
					'Thursday',
					'Friday',
					'Saturday'
				];

				// Array for month.
				var month = [
					'January',
					'February',
					'March',
					'April',
					'May',
					'June',
					'July',
					'August',
					'September',
					'October',
					'November',
					'December'
				];

				// Assign weekday, month, date, year.
				weekday = weekday[date_obj.getDay()];
				month = month[date_obj.getMonth()];

				// AM or PM?
				if(hour >= 12) {
					suffix = 'PM';
				}

				// Convert to 12-hour.
				if(hour > 12) {
					hour = hour - 12;
				} else if(hour === 0) {
					// Display 12:XX instead of 0:XX.
					hour = 12;
				}

				// Leading zero, if needed.
				if(minute < 10) {
					minute = '0' + minute;
				}

				// Build two HTML strings.
				var clock_time = weekday + ' ' + hour + ':' + minute + ' ' + suffix;
				var clock_date = month + ' ' + day + ', ' + year;

				// Shove in the HTML.
				$('#clock').html(clock_time).attr('title', clock_date);

				// Update every 60 seconds.
				setTimeout(JQD.init.clock, 60000);
			},
			//
			// Initialize the desktop.
			//
			desktop: function() {

				// Cancel mousedown, right-click.
				//								$(document).mousedown(function(ev) {
				//									if (!$(ev.target).closest('a').length) {
				//										JQD.util.clear_active();
				//										ev.preventDefault();//组织元素发生默认行为   注释掉了，否则input框被禁用
				//										ev.stopPropagation();//检查指定方法是否调用了该方法
				//									}
				//								}).bind('contextmenu', function() {
				//									return false;
				//								});

				// Relative or remote links?
				$('a').live('click', function(ev) {

					var url = $(this).attr('href');
					this.blur();
					if(url.match(/^#/)) {
						ev.preventDefault();
						ev.stopPropagation();
					} else {
						$(this).attr('target', '_blank');
					}
					//一直都是错的，不应该加在这里，每次点击完后不是起到双击打开的功能，下面才是 
					//var index = $(this).attr('orderr');
					//						for(var i=1,j=0;i<=6;i++,j++){
					//							$(".if"+i).attr("src",comNamess[j]);
					//						}
					//					}
					//结束
					//				$("iframe").attr("src","http://www.baidu.com");
				});
				// Make top menus active.
				$('a.menu_trigger').live('mousedown', function() {
					if($(this).next('ul.menu').is(':hidden')) {
						JQD.util.clear_active();
						$(this).addClass('active').next('ul.menu').show();
					} else {
						JQD.util.clear_active();
					}
				}).live('mouseenter', function() {
					// Transfer focus, if already open.
					if($('ul.menu').is(':visible')) {
						JQD.util.clear_active();
						$(this).addClass('active').next('ul.menu').show();
					}
				});

				// Desktop icons.  
				$('a.icon').live('mousedown', function() {
					// Highlight the icon.
					JQD.util.clear_active();
					$(this).addClass('active');
				}).live('click', function() {
					// Get the link's target.
					//					$($(this).attr("id","window_close");
					var x = $(this).attr('href');
					var y = $(x).find('a').attr('href');

					var xx = $(this).attr("id");
					var tt = xx.substring(4);

					//原来的	for(var i = 0, j = 0; i <= 20; i++, j++) {$(".if" + i).attr("src", comNamess[j]);}
					$(".if" + tt).attr("src", comNamess[tt]);

					//20个icon图标点击变换底色
					//
					$(".img_icon").each(function() {
						$(this).attr("src", $(this).attr("src1"));
					})
					$(this).find("img").attr("src", $(this).find("img").attr("src2"));

					// Show the taskbar button.
					if($(x).is(':hidden')) {
						$(x).remove().appendTo('#dock');
						$(x).show('fast');
					}

					// Bring window to front.
					JQD.util.window_flat();
					$(y).addClass('window_stack').show();
				}).live('mouseenter', function() {
					$(this).die('mouseenter').draggable({
						revert: false, //这里的true改成了false禁止禁止拖动
						containment: 'parent'
					});
				});

				//开始（左下角的智慧编程图标点击）
				$('li.icon1').live('click', function() {
					// Get the link's target.
					var x = $(this).attr('href');
					var y = $(x).find('a').attr('href');

					//					for(var i = 0, j = 0; i <= 20; i++, j++) {$(".if" + i).attr("src", comNamess[j]);}
					var i = 0;
					$(".if" + i).attr("src", comNamess[i]);

					// Show the taskbar button.
					if($(x).is(':hidden')) {
						$(x).remove().appendTo('#dock');
						$(x).show('fast');
					}

					// Bring window to front.
					JQD.util.window_flat();
					$(y).addClass('window_stack').show();
				}).live('mouseenter', function() {
					$(this).die('mouseenter').draggable({
						revert: true,
						containment: 'parent'
					});
				});

				//开始  地图-桃浦地图
				$('.map1').live('click', function() {
					// Get the link's target.
					var x = $(this).attr('href');

					var y = $(x).find('a').attr('href');
					console.log(y);

					//					for(var i = 0, j = 0; i <= 21; i++, j++) {$(".if" + i).attr("src", comNamess[j]);}
					var i = 13;
					$(".if" + i).attr("src", comNamess[i]);

					// Show the taskbar button.
					if($(x).is(':hidden')) {
						$(x).remove().appendTo('#dock');
						$(x).show('fast');
					}

					// Bring window to front.
					JQD.util.window_flat();
					$(y).addClass('window_stack').show();
				}).live('mouseenter', function() {
					$(this).die('mouseenter').draggable({
						revert: true,
						containment: 'parent'
					});
				});

				//点击关闭时清空当前网址
				//					$(".tp_close").click(function(){
				//						var yy=$("#IframeID21").attr('src','');
				//						
				//				})
				$(".window_close").click(function() {
					var xx = $(this).parent().parent().next().attr('src', ''); //获取当前对象的网址，使其置为空

				})

				//开始  九州云
				$('.jiuzhouyun').live('click', function() {
					// Get the link's target.
					var x = $(this).attr('href');

					var y = $(x).find('a').attr('href');
					console.log(y);

					var i = 14;
					$(".if" + i).attr("src", comNamess[14]);

					// Show the taskbar button.
					if($(x).is(':hidden')) {
						$(x).remove().appendTo('#dock');
						$(x).show('fast');
					}

					// Bring window to front.
					JQD.util.window_flat();
					$(y).addClass('window_stack').show();
				}).live('mouseenter', function() {
					$(this).die('mouseenter').draggable({
						revert: true,
						containment: 'parent'
					});
				});
				//				sxky点击
				$('.sxky').live('click', function() {
					// Get the link's target.
					var x = $(this).attr('href');

					var y = $(x).find('a').attr('href');
					console.log(y);

					var i = 15;
					$(".if" + i).attr("src", comNamess[15]);

					// Show the taskbar button.
					if($(x).is(':hidden')) {
						$(x).remove().appendTo('#dock');
						$(x).show('fast');
					}

					// Bring window to front.
					JQD.util.window_flat();
					$(y).addClass('window_stack').show();
				}).live('mouseenter', function() {
					$(this).die('mouseenter').draggable({
						revert: true,
						containment: 'parent'
					});
				});
				//开始  桃浦科技
				$('.tpkj').live('click', function() {
						// Get the link's target.
						var x = $(this).attr('href');

						var y = $(x).find('a').attr('href');

						var i = 16;
						$(".if" + i).attr("src", comNamess[16]);

						// Show the taskbar button.
						if($(x).is(':hidden')) {
							$(x).remove().appendTo('#dock');
							$(x).show('fast');
						}

						// Bring window to front.
						JQD.util.window_flat();
						$(y).addClass('window_stack').show();
					})
					.live('mouseenter', function() {
						$(this).die('mouseenter').draggable({
							revert: true,
							containment: 'parent'
						});
					});

				//开始  右侧图片-重庆两江1
				$('.cqlj').live('click', function() {
					// Get the link's target.
					var x = $(this).attr('href');

					var y = $(x).find('a').attr('href');
					console.log(y);

					var i = 17;
					$(".if" + i).attr("src", comNamess[17]);
					//document.getElementById("test_lep").innerHTML="此刻地址为："+comNamess[j];

					// Show the taskbar button.
					if($(x).is(':hidden')) {
						$(x).remove().appendTo('#dock');
						$(x).show('fast');
					}

					// Bring window to front.
					JQD.util.window_flat();
					$(y).addClass('window_stack').show();
				}).live('mouseenter', function() {
					$(this).die('mouseenter').draggable({
						revert: true,
						containment: 'parent'
					});
				});

				// Taskbar buttons.
				$('#dock a').live('click', function() {
					// Get the link's target.
					var x = $($(this).attr('href'));

					// Hide, if visible.
					if(x.is(':visible')) {
						x.hide();
					} else {
						// Bring window to front.
						JQD.util.window_flat();
						x.show().addClass('window_stack');
					}
				});

				// Make windows movable.
				$('div.window').live('mousedown', function() {
					// Bring window to front.
					JQD.util.window_flat();
					$(this).addClass('window_stack');
				}).live('mouseenter', function() {
					$(this).die('mouseenter').draggable({
						// Confine to desktop.
						// Movable via top bar only.
						cancel: 'a',
						containment: 'parent',
						handle: 'div.window_top'
					}).resizable({
						containment: 'parent',
						minWidth: 400,
						minHeight: 200
					});

					// Double-click top bar to resize, ala Windows OS.
				}).find('div.window_top').live('click', function() {
					JQD.util.window_resize(this);

					// Double click top bar icon to close, ala Windows OS.
				}).find('img').live('click', function() {
					// Traverse to the close button, and hide its taskbar button.
					$($(this).closest('div.window_top').find('a.window_close').attr('href')).hide('fast');
					$($(this).closest('div.window_top').find('#window_close').attr('href')).hide('fast');

					// Close the window itself.
					$(this).closest('div.window').hide();

					// Stop propagation to window's top bar.
					return false;
				});

				// Minimize the window.
				$('a.window_min').live('click', function() {
					$(this).closest('div.window').hide();
				});

				// Maximize or restore the window.
				$('a.window_resize').live('click', function() {
					JQD.util.window_resize(this);
				});

				// Close the window.
				$('a.window_close').live('click', function() {
					$(this).attr("src", "");
					$(this).closest('div.window').hide();
					$($(this).attr('href')).hide('fast');

				});
				$('#window_close').live('click', function() {
					$(this).attr("src", "");
					$(this).closest('div.window').hide();
					$($(this).attr('href')).hide('fast');

				});

				// Show desktop button, ala Windows OS.
				$('#show_desktop').live('click', function() {
					// If any windows are visible, hide all.
					if($('div.window:visible').length) {
						$('div.window').hide();
					} else {
						// Otherwise, reveal hidden windows that are open.
						$('#dock li:visible a').each(function() {
							$($(this).attr('href')).show();
						});
					}
				});

				$('table.data').each(function() {
					// Add zebra striping, ala Mac OS X.
					$(this).find('tbody tr:odd').addClass('zebra');
				}).find('tr').live('mousedown', function() {
					// Highlight row, ala Mac OS X.
					$(this).closest('tr').addClass('active');
				});
			},
			wallpaper: function() {
				// Add wallpaper last, to prevent blocking.
				//				if ($('#desktop').length) {
				//					$('body').prepend('<img src="./img/bj.jpg" id="wallpaper" class="abs" />');//注释：选择照片路径 ../不显示
				//				}
			}
		},
		util: {
			//
			// Clear active states, hide menus.
			//
			clear_active: function() {
				$('a.active, tr.active').removeClass('active');
				$('ul.menu').hide();
			},
			//
			// Zero out window z-index.
			//
			window_flat: function() {
				$('div.window').removeClass('window_stack');
			},
			//
			// Resize modal window.
			//
			window_resize: function(el) {
				// Nearest parent window.
				var win = $(el).closest('div.window');

				// Is it maximized already?
				if(win.hasClass('window_full')) {
					// Restore window position.
					win.removeClass('window_full').css({
						'top': win.attr('data-t'),
						'left': win.attr('data-l'),
						'right': win.attr('data-r'),
						'bottom': win.attr('data-b'),
						'width': win.attr('data-w'),
						'height': win.attr('data-h')
					});
				} else {
					win.attr({
						// Save window position.
						'data-t': win.css('top'),
						'data-l': win.css('left'),
						'data-r': win.css('right'),
						'data-b': win.css('bottom'),
						'data-w': win.css('width'),
						'data-h': win.css('height')
					}).addClass('window_full').css({
						// Maximize dimensions.
						'top': '0',
						'left': '0',
						'right': '0',
						'bottom': '0',
						'width': '100%',
						'height': '100%'
					});
				}

				// Bring window to front.
				JQD.util.window_flat();
				win.addClass('window_stack');
			}
		}
	};
	// Pass in jQuery.
})(jQuery, this);