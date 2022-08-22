! function(p) {
    "use strict";
    p.breakingNews = function(e, t) {
        var i = {
                effect: "scroll",
                direction: "ltr",
                height: 40,
                fontSize: "default",
                themeColor: "default",
                background: "default",
                borderWidth: 1,
                radius: 2,
                source: "html",
                rss2jsonApiKey: "",
                play: !0,
                delayTimer: 4e3,
                scrollSpeed: 2,
                stopOnHover: !0,
                position: "auto",
                zIndex: 99999
            },
            a = this;
        a.settings = {},
        a._element = p(e),
        a._label = a._element.children(".bn-label"),
        a._news = a._element.children(".bn-news"),
        a._ul = a._news.children("ul"),
        a._li = a._ul.children("li"),
        a._controls = a._element.children(".bn-controls"),
        a._prev = a._controls.find(".bn-prev").parent(),
        a._action = a._controls.find(".bn-action").parent(),
        a._next = a._controls.find(".bn-next").parent(),
        a._pause = !1, a._controlsIsActive = !0,
        a._totalNews = a._ul.children("li").length,
        a._activeNews = 0, a._interval = !1,
        a._frameId = null;
        var o = function() {
                if (0 < a._label.length && ("rtl" == a.settings.direction ? a._news.css({
                        right: a._label.outerWidth()
                    }) : a._news.css({
                        left: a._label.outerWidth()
                    })), 0 < a._controls.length) {
                    var e = a._controls.outerWidth();
                    "rtl" == a.settings.direction ? a._news.css({
                        left: e
                    }) : a._news.css({
                        right: e
                    })
                }
                if ("scroll" === a.settings.effect) {
                    var t = 0;
                    a._li.each(function() {
                        t += p(this).outerWidth()
                    }), t += 50, a._ul.css({
                        width: t
                    })
                }
            },
            s = function() {
                var l = new XMLHttpRequest;
                l.onreadystatechange = function() {
                    if (4 == l.readyState && 200 == l.status) {
                        var e = JSON.parse(l.responseText),
                            t = "",
                            i = "";
                        switch (a.settings.source.showingField) {
                            case "title":
                                i = "title";
                                break;
                            case "description":
                                i = "description";
                                break;
                            case "link":
                                i = "link";
                                break;
                            default:
                                i = "title"
                        }
                        var s = "";
                        void 0 !== a.settings.source.seperator && void 0 !== typeof a.settings.source.seperator && (s = a.settings.source.seperator);
                        for (var n = 0; n < e.items.length; n++) a.settings.source.linkEnabled ? t += '<li><a target="' + a.settings.source.target + '" href="' + e.items[n].link + '">' + s + e.items[n][i] + "</a></li>" : t += "<li><a>" + s + e.items[n][i] + "</a></li>";
                        a._ul.empty().append(t), a._li = a._ul.children("li"), a._totalNews = a._ul.children("li").length, o(), "scroll" != a.settings.effect && d(), a._li.find(".bn-seperator").css({
                            height: a.settings.height - 2 * a.settings.borderWidth
                        }), f()
                    }
                }, l.open("GET", "https://api.rss2json.com/v1/api.json?rss_url=" + a.settings.source.url + "&count=" + a.settings.source.limit + "&api_key=" + a.settings.source.rss2jsonApiKey, !0), l.send()
            },
            n = function() {
                p.getJSON(a.settings.source.url, function(e) {
                    var t = "",
                        i = "";
                    i = "undefined" === a.settings.source.showingField ? "title" : a.settings.source.showingField;
                    var s = "";
                    void 0 !== a.settings.source.seperator && void 0 !== typeof a.settings.source.seperator && (s = a.settings.source.seperator);
                    for (var n = 0; n < e.length && !(n >= a.settings.source.limit); n++) a.settings.source.linkEnabled ? t += '<li><a target="' + a.settings.source.target + '" href="' + e[n].link + '">' + s + e[n][i] + "</a></li>" : t += "<li><a>" + s + e[n][i] + "</a></li>", "undefined" === e[n][i] && console.log('"' + i + '" does not exist in this json.');
                    a._ul.empty().append(t), a._li = a._ul.children("li"), a._totalNews = a._ul.children("li").length, o(), "scroll" != a.settings.effect && d(), a._li.find(".bn-seperator").css({
                        height: a.settings.height - 2 * a.settings.borderWidth
                    }), f()
                })
            },
            l = function() {
                var e = parseFloat(a._ul.css("marginLeft"));
                e -= a.settings.scrollSpeed / 2, a._ul.css({
                    marginLeft: e
                }), e <= -a._ul.find("li:first-child").outerWidth() && (a._ul.find("li:first-child").insertAfter(a._ul.find("li:last-child")), a._ul.css({
                    marginLeft: 0
                })), !1 === a._pause && (a._frameId = requestAnimationFrame(l), window.requestAnimationFrame && a._frameId || setTimeout(l, 16))
            },
            r = function() {
                var e = parseFloat(a._ul.css("marginRight"));
                e -= a.settings.scrollSpeed / 2, a._ul.css({
                    marginRight: e
                }), e <= -a._ul.find("li:first-child").outerWidth() && (a._ul.find("li:first-child").insertAfter(a._ul.find("li:last-child")), a._ul.css({
                    marginRight: 0
                })), !1 === a._pause && (a._frameId = requestAnimationFrame(r)), window.requestAnimationFrame && a._frameId || setTimeout(r, 16)
            },
            c = function() {
                "rtl" === a.settings.direction ? a._ul.stop().animate({
                    marginRight: -a._ul.find("li:first-child").outerWidth()
                }, 300, function() {
                    a._ul.find("li:first-child").insertAfter(a._ul.find("li:last-child")), a._ul.css({
                        marginRight: 0
                    }), a._controlsIsActive = !0
                }) : a._ul.stop().animate({
                    marginLeft: -a._ul.find("li:first-child").outerWidth()
                }, 300, function() {
                    a._ul.find("li:first-child").insertAfter(a._ul.find("li:last-child")), a._ul.css({
                        marginLeft: 0
                    }), a._controlsIsActive = !0
                })
            },
            u = function() {
                "rtl" === a.settings.direction ? (0 <= parseInt(a._ul.css("marginRight"), 10) && (a._ul.css({
                    "margin-right": -a._ul.find("li:last-child").outerWidth()
                }), a._ul.find("li:last-child").insertBefore(a._ul.find("li:first-child"))), a._ul.stop().animate({
                    marginRight: 0
                }, 300, function() {
                    a._controlsIsActive = !0
                })) : (0 <= parseInt(a._ul.css("marginLeft"), 10) && (a._ul.css({
                    "margin-left": -a._ul.find("li:last-child").outerWidth()
                }), a._ul.find("li:last-child").insertBefore(a._ul.find("li:first-child"))), a._ul.stop().animate({
                    marginLeft: 0
                }, 300, function() {
                    a._controlsIsActive = !0
                }))
            },
            d = function() {
                switch (a._controlsIsActive = !0, a.settings.effect) {
                    case "typography":
                        a._ul.find("li").hide(), a._ul.find("li").eq(a._activeNews).width(30).show(), a._ul.find("li").eq(a._activeNews).animate({
                            width: "100%",
                            opacity: 1
                        }, 1500);
                        break;
                    case "fade":
                        a._ul.find("li").hide(), a._ul.find("li").eq(a._activeNews).fadeIn();
                        break;
                    case "slide-down":
                        a._totalNews <= 1 ? a._ul.find("li").animate({
                            top: 30,
                            opacity: 0
                        }, 300, function() {
                            p(this).css({
                                top: -30,
                                opacity: 0,
                                display: "block"
                            }), p(this).animate({
                                top: 0,
                                opacity: 1
                            }, 300)
                        }) : (a._ul.find("li:visible").animate({
                            top: 30,
                            opacity: 0
                        }, 300, function() {
                            p(this).hide()
                        }), a._ul.find("li").eq(a._activeNews).css({
                            top: -30,
                            opacity: 0
                        }).show(), a._ul.find("li").eq(a._activeNews).animate({
                            top: 0,
                            opacity: 1
                        }, 300));
                        break;
                    case "slide-up":
                        a._totalNews <= 1 ? a._ul.find("li").animate({
                            top: -30,
                            opacity: 0
                        }, 300, function() {
                            p(this).css({
                                top: 30,
                                opacity: 0,
                                display: "block"
                            }), p(this).animate({
                                top: 0,
                                opacity: 1
                            }, 300)
                        }) : (a._ul.find("li:visible").animate({
                            top: -30,
                            opacity: 0
                        }, 300, function() {
                            p(this).hide()
                        }), a._ul.find("li").eq(a._activeNews).css({
                            top: 30,
                            opacity: 0
                        }).show(), a._ul.find("li").eq(a._activeNews).animate({
                            top: 0,
                            opacity: 1
                        }, 300));
                        break;
                    case "slide-left":
                        a._totalNews <= 1 ? a._ul.find("li").animate({
                            left: "50%",
                            opacity: 0
                        }, 300, function() {
                            p(this).css({
                                left: -50,
                                opacity: 0,
                                display: "block"
                            }), p(this).animate({
                                left: 0,
                                opacity: 1
                            }, 300)
                        }) : (a._ul.find("li:visible").animate({
                            left: "50%",
                            opacity: 0
                        }, 300, function() {
                            p(this).hide()
                        }), a._ul.find("li").eq(a._activeNews).css({
                            left: -50,
                            opacity: 0
                        }).show(), a._ul.find("li").eq(a._activeNews).animate({
                            left: 0,
                            opacity: 1
                        }, 300));
                        break;
                    case "slide-right":
                        a._totalNews <= 1 ? a._ul.find("li").animate({
                            left: "-50%",
                            opacity: 0
                        }, 300, function() {
                            p(this).css({
                                left: "50%",
                                opacity: 0,
                                display: "block"
                            }), p(this).animate({
                                left: 0,
                                opacity: 1
                            }, 300)
                        }) : (a._ul.find("li:visible").animate({
                            left: "-50%",
                            opacity: 0
                        }, 300, function() {
                            p(this).hide()
                        }), a._ul.find("li").eq(a._activeNews).css({
                            left: "50%",
                            opacity: 0
                        }).show(), a._ul.find("li").eq(a._activeNews).animate({
                            left: 0,
                            opacity: 1
                        }, 300));
                        break;
                    default:
                        a._ul.find("li").hide(), a._ul.find("li").eq(a._activeNews).show()
                }
            },
            f = function() {
                if (a._pause = !1, a.settings.play) switch (a.settings.effect) {
                    case "scroll":
                        "rtl" === a.settings.direction ? a._ul.width() > a._news.width() ? r() : a._ul.css({
                            marginRight: 0
                        }) : a._ul.width() > a._news.width() ? l() : a._ul.css({
                            marginLeft: 0
                        });
                        break;
                    default:
                        a.pause(), a._interval = setInterval(function() {
                            a.next()
                        }, a.settings.delayTimer)
                }
            },
            _ = function() {
                a._element.width() < 480 ? (a._label.hide(), "rtl" == a.settings.direction ? a._news.css({
                    right: 0
                }) : a._news.css({
                    left: 0
                })) : (a._label.show(), "rtl" == a.settings.direction ? a._news.css({
                    right: a._label.outerWidth()
                }) : a._news.css({
                    left: a._label.outerWidth()
                }))
            };
        a.init = function() {
            if (a.settings = p.extend({}, i, t), "fixed-top" === a.settings.position ? a._element.addClass("bn-fixed-top").css({
                    "z-index": a.settings.zIndex
                }) : "fixed-bottom" === a.settings.position && a._element.addClass("bn-fixed-bottom").css({
                    "z-index": a.settings.zIndex
                }), "default" != a.settings.fontSize && a._element.css({
                    "font-size": a.settings.fontSize
                }), "default" != a.settings.themeColor && (a._element.css({
                    "border-color": a.settings.themeColor,
                    color: a.settings.themeColor
                }), a._label.css({
                    background: a.settings.themeColor
                })), "default" != a.settings.background && a._element.css({
                    background: a.settings.background
                }), a._element.css({
                    height: a.settings.height,
                    "line-height": a.settings.height - 2 * a.settings.borderWidth + "px",
                    "border-radius": a.settings.radius,
                    "border-width": a.settings.borderWidth
                }), a._li.find(".bn-seperator").css({
                    height: a.settings.height - 2 * a.settings.borderWidth
                }), a._element.addClass("bn-effect-" + a.settings.effect + " bn-direction-" + a.settings.direction), o(), "object" == typeof a.settings.source) switch (a.settings.source.type) {
                case "rss":
                    "rss2json" === a.settings.source.usingApi ? (s(), 0 < a.settings.source.refreshTime && setInterval(function() {
                        a._activeNews = 0, a.pause(), a._ul.empty().append('<li style="display:block; padding-left:10px;"><span class="bn-loader-text">......</span></li>'), setTimeout(function() {
                            s()
                        }, 1e3)
                    }, 1e3 * a.settings.source.refreshTime * 60)) : ((l = new XMLHttpRequest).open("GET", "https://query.yahooapis.com/v1/public/yql?q=" + encodeURIComponent('select * from rss where url="' + a.settings.source.url + '" limit ' + a.settings.source.limit) + "&format=json", !0), l.onreadystatechange = function() {
                        if (4 == l.readyState)
                            if (200 == l.status) {
                                var e = JSON.parse(l.responseText),
                                    t = "",
                                    i = "";
                                switch (a.settings.source.showingField) {
                                    case "title":
                                        i = "title";
                                        break;
                                    case "description":
                                        i = "description";
                                        break;
                                    case "link":
                                        i = "link";
                                        break;
                                    default:
                                        i = "title"
                                }
                                var s = "";
                                "undefined" != a.settings.source.seperator && void 0 !== a.settings.source.seperator && (s = a.settings.source.seperator);
                                for (var n = 0; n < e.query.results.item.length; n++) a.settings.source.linkEnabled ? t += '<li><a target="' + a.settings.source.target + '" href="' + e.query.results.item[n].link + '">' + s + e.query.results.item[n][i] + "</a></li>" : t += "<li><a>" + s + e.query.results.item[n][i] + "</a></li>";
                                a._ul.empty().append(t), a._li = a._ul.children("li"), a._totalNews = a._ul.children("li").length, o(), "scroll" != a.settings.effect && d(), a._li.find(".bn-seperator").css({
                                    height: a.settings.height - 2 * a.settings.borderWidth
                                }), f()
                            } else a._ul.empty().append('<li><span class="bn-loader-text">' + a.settings.source.errorMsg + "</span></li>")
                    }, l.send(null));
                    break;
                case "json":
                    n(), 0 < a.settings.source.refreshTime && setInterval(function() {
                        a._activeNews = 0, a.pause(), a._ul.empty().append('<li style="display:block; padding-left:10px;"><span class="bn-loader-text">......</span></li>'), setTimeout(function() {
                            n()
                        }, 1e3)
                    }, 1e3 * a.settings.source.refreshTime * 60);
                    break;
                default:
                    console.log('Please check your "source" object parameter. Incorrect Value')
            } else "html" === a.settings.source ? ("scroll" != a.settings.effect && d(), f()) : console.log('Please check your "source" parameter. Incorrect Value');
            var l;
            a.settings.play ? a._action.find("span").removeClass("bn-play").addClass("bn-pause") : a._action.find("span").removeClass("bn-pause").addClass("bn-play"), a._element.on("mouseleave", function(e) {
                var t = p(document.elementFromPoint(e.clientX, e.clientY)).parents(".bn-breaking-news")[0];
                p(this)[0] !== t && (!0 === a.settings.stopOnHover ? !0 === a.settings.play && a.play() : !0 === a.settings.play && !0 === a._pause && a.play())
            }), a._element.on("mouseenter", function() {
                !0 === a.settings.stopOnHover && a.pause()
            }), a._next.on("click", function() {
                a._controlsIsActive && (a._controlsIsActive = !1, a.pause(), a.next())
            }), a._prev.on("click", function() {
                a._controlsIsActive && (a._controlsIsActive = !1, a.pause(), a.prev())
            }), a._action.on("click", function() {
                a._controlsIsActive && (a._action.find("span").hasClass("bn-pause") ? (a._action.find("span").removeClass("bn-pause").addClass("bn-play"), a.stop()) : (a.settings.play = !0, a._action.find("span").removeClass("bn-play").addClass("bn-pause")))
            }), _(), p(window).on("resize", function() {
                _(), a.pause(), a.play()
            })
        }, a.pause = function() {
            a._pause = !0, clearInterval(a._interval), cancelAnimationFrame(a._frameId)
        }, a.stop = function() {
            a._pause = !0, a.settings.play = !1
        }, a.play = function() {
            f()
        }, a.next = function() {
            ! function() {
                switch (a.settings.effect) {
                    case "scroll":
                        c();
                        break;
                    default:
                        a._activeNews++, a._activeNews >= a._totalNews && (a._activeNews = 0), d()
                }
            }()
        }, a.prev = function() {
            ! function() {
                switch (a.settings.effect) {
                    case "scroll":
                        u();
                        break;
                    default:
                        a._activeNews--, a._activeNews < 0 && (a._activeNews = a._totalNews - 1), d()
                }
            }()
        }, a.init()
    }, p.fn.breakingNews = function(t) {
        return this.each(function() {
            if (null == p(this).data("breakingNews")) {
                var e = new p.breakingNews(this, t);
                p(this).data("breakingNews", e)
            }
        })
    }
}(jQuery);

(function($) {
  'use strict';

$( document ).ready(function() {
		
		// Home Slider
		var $owlHome = $('.home-slider');
		$owlHome.owlCarousel({
		  rtl: $("html").attr("dir") == 'rtl' ? true : false,
		  items: 1,
		  autoplay: true,
		  autoplayTimeout: 10000,
		  margin: 0,
		  loop: true,
		  dots: true,
		  nav: false,
		  navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		  singleItem: true,
		  transitionStyle: "fade",
		  touchDrag: true,
		  mouseDrag: true,
		  responsive: {
			0: {
			  nav: false
			},
			768: {
			  nav: true
			},
			992: {
			  nav: true
			}
		  }
		});
		$owlHome.owlCarousel();
		$owlHome.on('translate.owl.carousel', function (event) {
			var data_anim = $("[data-animation]");
			data_anim.each(function() {
				var anim_name = $(this).data('animation');
				$(this).removeClass('animated ' + anim_name).css('opacity', '0');
			});
		});
		$("[data-delay]").each(function() {
			var anim_del = $(this).data('delay');
			$(this).css('animation-delay', anim_del);
		});
		$("[data-duration]").each(function() {
			var anim_dur = $(this).data('duration');
			$(this).css('animation-duration', anim_dur);
		});
		$owlHome.on('translated.owl.carousel', function() {
			var data_anim = $owlHome.find('.owl-item.active').find("[data-animation]");
			data_anim.each(function() {
				var anim_name = $(this).data('animation');
				$(this).addClass('animated ' + anim_name).css('opacity', '1');
			});
		});
		
		
	   // Testimonial Slider
      var owlTestimonial = $(".testimonials-slider");
      owlTestimonial.owlCarousel({
          rtl: $("html").attr("dir") == 'rtl' ? true : false,
          loop: true,
          nav: false,
          margin: 2,
          items: 1,
          center: true,
          mouseDrag: true,
          touchDrag: true,
          autoplay: true,
          autoplayTimeout: 12000,
          responsive: {
              0: {
                  stagePadding: 0,
                  dots: false,
                  items: 1
              },
              768: {
                  stagePadding: 0,
                  dots: true,
                  items: 2
              },
              992: {
                  stagePadding: 0,
                  dots: true,
                  items: 3,
              }
          }
      });
      // Custom Button
      $('.testimonial-nav .owl-next').click(function() {
        owlTestimonial.trigger('next.owl.carousel');
      });
      $('.testimonial-nav .owl-prev').click(function() {
        owlTestimonial.trigger('prev.owl.carousel');
      });
	
	
		// Blog Slider
	  var owlBlog = $(".blog-slider");
	  owlBlog.owlCarousel({
		  rtl: $("html").attr("dir") == 'rtl' ? true : false,
		  loop: true,
		  nav: false,
		  margin: 2,
		  mouseDrag: true,
		  touchDrag: true,
		  autoplay: true,
		  autoplayTimeout: 12000,
		  responsive: {
			  0: {
				  stagePadding: 0,
				  dots: false,
				  items: 1
			  },
			  768: {
				  stagePadding: 0,
				  dots: true,
				  items: 2
			  },
			  992: {
				  stagePadding: 0,
				  dots: true,
				  items: 3,
			  }
		  }
	  });
	  // Custom Button
	  $('.blog-nav .owl-next').click(function() {
		owlBlog.trigger('next.owl.carousel');
	  });
	  $('.blog-nav .owl-prev').click(function() {
		owlBlog.trigger('prev.owl.carousel');
	  });
		  
    $(window).on('load', function () {
      if ($('.storebiz-popup').length) {
            $.magnificPopup.open({
              items: [{
                src: '#storebiz-popup',
                type: 'inline'
              }],
              fixedContentPos: true,
              midClick: true,
              closeOnBgClick: false,
              removalDelay: 300,
              mainClass: 'mfp-fade',
              callbacks: {
                open: function() { 
                    $('.storebiz-popup .mfp-close').on('click',function(e){
                      e.preventDefault();
                      $.magnificPopup.close();
                    }); 
                }
              }
            });
            localStorage.setItem('storebiz_popup', 'true');
      }
    });


    // ScrollUp
    $(window).on('scroll', function () {
      if ($(this).scrollTop() > 200) {
        $('.scrollingUp').addClass('is-active');
      } else {
        $('.scrollingUp').removeClass('is-active');
      }
    });
    $('.scrollingUp').on('click', function () {
      $("html, body").animate({
        scrollTop: 0
      }, 600);
      return false;
    });


    // Sticky Header
    $(window).on('scroll', function() {
      if ($(window).scrollTop() >= 250) {
          $('.is-sticky-on').addClass('is-sticky-menu');
      }
      else {
          $('.is-sticky-on').removeClass('is-sticky-menu');
      }
    });

    // Breadcrumb Sticky Menu
    $(window).on('scroll', function() {
      if ($(window).scrollTop() >= 420) {
          $('.breadcrumb-sticky-on').addClass('breadcrumb-sticky-menu');
      }
      else {
          $('.breadcrumb-sticky-on').removeClass('breadcrumb-sticky-menu');
      }
    });

    // Service Section Load Button Filter
    $(".service-home .st-load-item").slice(0, 3).show();
    $(".service-home .st-load-btn").on('click', function (e) {
        e.preventDefault();
        $(".service-home .st-load-btn").addClass("loadspinner");
        $(".service-home .st-load-btn").animate({
                display: "block"
            }, 2500,
            function () {
                // Animation complete.                
                // $(".load-2:hidden").slice(0, 2).slideDown()
                // .each(function() {
                //   $('#grid').shuffle('appended', $(this));
                // });
                $(".service-home .st-load-item:hidden").slice(0, 3).slideDown();
                if ($(".service-home .st-load-item:hidden").length === 0) {
                    $(".service-home .st-load-btn").text("No more");
                }
                $(".service-home .st-load-btn").removeClass("loadspinner");
            }
        );
    });
    $(".service-page .st-load-item").slice(0, 6).show();
    $(".service-page .st-load-btn").on('click', function (e) {
        e.preventDefault();
        $(".service-page .st-load-btn").addClass("loadspinner");
        $(".service-page .st-load-btn").animate({
                display: "block"
            }, 2500,
            function () {
                // Animation complete.                
                // $(".load-2:hidden").slice(0, 2).slideDown()
                // .each(function() {
                //   $('#grid').shuffle('appended', $(this));
                // });
                $(".service-page .st-load-item:hidden").slice(0, 3).slideDown();
                if ($(".service-page .st-load-item:hidden").length === 0) {
                    $(".service-page .st-load-btn").text("No more");
                }
                $(".service-page .st-load-btn").removeClass("loadspinner");
            }
        );
    });

    //Projects Section Load Button Filter
    $("#projects-section .st-load-item").slice(0, 6).show();
    $("#projects-section .st-load-btn").on('click', function (e) {
        e.preventDefault();
        $("#projects-section .st-load-btn").addClass("loadspinner");
        $("#projects-section .st-load-btn").animate({
                display: "block"
            }, 2500,
            function () {
                $("#projects-section .st-load-item:hidden").slice(0, 3).slideDown();
                if ($("#projects-section .st-load-item:hidden").length === 0) {
                    $("#projects-section .st-load-btn").text("No more");
                }
                $("#projects-section .st-load-btn").removeClass("loadspinner");
            }
        );
    });

    if( $('.browse-menu ul.main-menu').children().length >= 6 ) {
        $(".browse-menu").addClass("active");
        $(".browse-menu ul.main-menu").append('<li class="menu-item more-item"><button type="button" class="browse-more"><span>More Category</span> <i class="fa fa-plus"></i></button></li>');
        $(".browse-menu > ul.main-menu > li:not(.more-item)").slice(0, 6).show();
        $(".browse-more").on('click', function (e) {
            //e.preventDefault();
            if (!$(".browse-more").hasClass("active")) {
                $(".browse-more").addClass("active");
                $('.browse-more i').removeClass('fa-plus').addClass("fa-minus");
                $(".browse-more").animate({
                        display: "block"
                    }, 500,
                    function () {
                        $(".browse-menu > ul.main-menu > li:not(.more-item):hidden").addClass('actived').slideDown(200);
                        if ($(".browse-menu > ul.main-menu > li:not(.more-item):hidden").length === 0) {
                            $(".browse-more").html('<span>No More</span> <i class="fa fa-minus"></i>');
                        }
                    }
                );
            } else {
                $(".browse-more").removeClass("active");
                $(".browse-more").animate({
                        display: "none"
                    }, 500,
                    function () {
                        if ($(".browse-menu > ul.main-menu > li:not(.more-item)").hasClass('actived')) {
                            $(".browse-menu > ul.main-menu > li:not(.more-item).actived").slice(0, 6).slideUp(200);
                            $(".browse-more").html('<span>More Category</span> <i class="fa fa-plus"></i>');
                        }
                    }
                );
            }
        });
    }

    $('.browse-cat').hasClass('vertical-is-active') ? browseMenuAccessibility() : $('.browse-btn').focus();
    
    function browseMenuAccessibility() {
        var e, t, i, n = document.querySelector(".browse-cat");
        let a = document.querySelector(".browse-btn"),
            s = n.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'),
            o = s[s.length - 1];
        if (!n) return !1;
        for (t = 0, i = (e = n.getElementsByTagName("a")).length; t < i; t++) e[t].addEventListener("focus", c, !0), e[t].addEventListener("blur", c, !0);

        function c() {
            for (var e = this; - 1 === e.className.indexOf("browse-cat-build");) "li" === e.tagName.toLowerCase() && (-1 !== e.className.indexOf("focus") ? e.className = e.className.replace(" focus", "") : e.className += " focus"), e = e.parentElement
        }
        document.addEventListener("keydown", function(e) {
            ("Tab" === e.key || 9 === e.keyCode) && (e.shiftKey ? document.activeElement === a && (o.focus(), e.preventDefault()) : document.activeElement === o && (a.focus(), e.preventDefault()))
        })
    }
    
    // Animated Typing Text
    var typingText = function (el, toRotate, period) {
      this.toRotate = toRotate;
      this.el = el;
      this.loopNum = 0;
      this.period = parseInt(period, 10) || 2000;
      this.txt = "";
      this.tick();
      this.isDeleting = false;
    };
    typingText.prototype.tick = function () {
      var i = this.loopNum % this.toRotate.length;
      var fullTxt = this.toRotate[i];

      if (this.isDeleting) {
        this.txt = fullTxt.substring(0, this.txt.length - 1);
      } else {
        this.txt = fullTxt.substring(0, this.txt.length + 1);
      }

      this.el.innerHTML = '<span class="wrap">' + this.txt + "</span>";

      var that = this;
      var delta = 200 - Math.random() * 100;

      if (this.isDeleting) {
        delta /= 2;
      }

      if (!this.isDeleting && this.txt === fullTxt) {
        delta = this.period;
        this.isDeleting = true;
      } else if (this.isDeleting && this.txt === "") {
        this.isDeleting = false;
        this.loopNum++;
        delta = 500;
      }

      setTimeout(function () {
        that.tick();
      }, delta);
    };
    window.onload = function () {
      var elements = document.getElementsByClassName("typewrite");
      for (var i = 0; i < elements.length; i++) {
        var toRotate = elements[i].getAttribute("data-type");
        var period = elements[i].getAttribute("data-period");
        if (toRotate) {
          new typingText(elements[i], JSON.parse(toRotate), period);
        }
      }
      // INJECT CSS
      var css = document.createElement("style");
      css.type = "text/css";
      css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #111111}";
      document.body.appendChild(css);
    };

    // Perspective Hover Effect
    var perspectiveSettings = [
    {},
    {
      movement: {
        imgWrapper : {
          translation : {x: 10, y: 10, z: 30},
          rotation : {x: 0, y: -10, z: 0},
          reverseAnimation : {duration : 200, easing : 'easeOutQuad'}
        },
        lines : {
          translation : {x: 10, y: 10, z: [0,70]},
          rotation : {x: 0, y: 0, z: -2},
          reverseAnimation : {duration : 2000, easing : 'easeOutExpo'}
        },
        caption : {
          rotation : {x: 0, y: 0, z: 2},
          reverseAnimation : {duration : 200, easing : 'easeOutQuad'}
        },
        overlay : {
          translation : {x: 10, y: -10, z: 0},
          rotation : {x: 0, y: 0, z: 2},
          reverseAnimation : {duration : 2000, easing : 'easeOutExpo'}
        },
        shine : {
          translation : {x: 100, y: 100, z: 0},
          reverseAnimation : {duration : 200, easing : 'easeOutQuad'}
        }
      }
    },
    {
      movement: {
        imgWrapper : {
          rotation : {x: -5, y: 10, z: 0},
          reverseAnimation : {duration : 900, easing : 'easeOutCubic'}
        },
        caption : {
          translation : {x: 30, y: 30, z: [0,40]},
          rotation : {x: [0,15], y: 0, z: 0},
          reverseAnimation : {duration : 1200, easing : 'easeOutExpo'}
        },
        overlay : {
          translation : {x: 10, y: 10, z: [0,20]},
          reverseAnimation : {duration : 1000, easing : 'easeOutExpo'}
        },
        shine : {
          translation : {x: 100, y: 100, z: 0},
          reverseAnimation : {duration : 900, easing : 'easeOutCubic'}
        }
      }
    },
    {
      movement: {
        imgWrapper : {
          rotation : {x: -5, y: 10, z: 0},
          reverseAnimation : {duration : 50, easing : 'easeOutQuad'}
        },
        caption : {
          translation : {x: 20, y: 20, z: 0},
          reverseAnimation : {duration : 200, easing : 'easeOutQuad'}
        },
        overlay : {
          translation : {x: 5, y: -5, z: 0},
          rotation : {x: 0, y: 0, z: 6},
          reverseAnimation : {duration : 1000, easing : 'easeOutQuad'}
        },
        shine : {
          translation : {x: 50, y: 50, z: 0},
          reverseAnimation : {duration : 50, easing : 'easeOutQuad'}
        }
      }
    },
    {
      movement: {
        imgWrapper : {
          translation : {x: 0, y: -8, z: 0},
          rotation : {x: 3, y: 3, z: 0},
          reverseAnimation : {duration : 1200, easing : 'easeOutExpo'}
        },
        lines : {
          translation : {x: 15, y: 15, z: [0,15]},
          reverseAnimation : {duration : 1200, easing : 'easeOutExpo'}
        },
        overlay : {
          translation : {x: 0, y: 8, z: 0},
          reverseAnimation : {duration : 600, easing : 'easeOutExpo'}
        },
        caption : {
          translation : {x: 10, y: -15, z: 0},
          reverseAnimation : {duration : 900, easing : 'easeOutExpo'}
        },
        shine : {
          translation : {x: 50, y: 50, z: 0},
          reverseAnimation : {duration : 1200, easing : 'easeOutExpo'}
        }
      }
    },
    {
      movement: {
        lines : {
          translation : {x: -5, y: 5, z: 0},
          reverseAnimation : {duration : 1000, easing : 'easeOutExpo'}
        },
        caption : {
          translation : {x: 15, y: 15, z: 0},
          rotation : {x: 0, y: 0, z: 3},
          reverseAnimation : {duration : 1500, easing : 'easeOutElastic', elasticity : 700}
        },
        overlay : {
          translation : {x: 15, y: -15, z: 0},
          reverseAnimation : {duration : 500,easing : 'easeOutExpo'}
        },
        shine : {
          translation : {x: 50, y: 50, z: 0},
          reverseAnimation : {duration : 500, easing : 'easeOutExpo'}
        }
      }
    },
    {
      movement: {
        imgWrapper : {
          translation : {x: 5, y: 5, z: 0},
          reverseAnimation : {duration : 800, easing : 'easeOutQuart'}
        },
        caption : {
          translation : {x: 10, y: 10, z: [0,50]},
          reverseAnimation : {duration : 1000, easing : 'easeOutQuart'}
        },
        shine : {
          translation : {x: 50, y: 50, z: 0},
          reverseAnimation : {duration : 800, easing : 'easeOutQuart'}
        }
      }
    },
    {
      movement: {
        lines : {
          translation : {x: 40, y: 40, z: 0},
          reverseAnimation : {duration : 1500, easing : 'easeOutElastic'}
        },
        caption : {
          translation : {x: 20, y: 20, z: 0},
          rotation : {x: 0, y: 0, z: -5},
          reverseAnimation : {duration : 1000, easing : 'easeOutExpo'}
        },
        overlay : {
          translation : {x: -30, y: -30, z: 0},
          rotation : {x: 0, y: 0, z: 3},
          reverseAnimation : {duration : 750, easing : 'easeOutExpo'}
        },
        shine : {
          translation : {x: 100, y: 100, z: 0},
          reverseAnimation : {duration : 750, easing : 'easeOutExpo'}
        }
      }
    }];

    function init() {
      var idx = 0;
      [].slice.call(document.querySelectorAll('.tilter')).forEach(function(el, pos) { 
        idx = pos%2 === 0 ? idx+1 : idx;
        new TiltFx(el, perspectiveSettings[idx-1]);
      });
    }
    init();
});


  // Tab Filter
  $(window).on('load', function () {
    var postFilter = $('.st-filter-init');
    $.each(postFilter,function (index,value) {
        var el = $(this);
        var parentClass = $(this).parent().attr('class');
        var $selector = $('#'+el.attr('id'));
        if ($selector.hasClass('pricing-init')) {
          $($selector).imagesLoaded(function () {
              var festivarMasonry = $($selector).isotope({
                  itemSelector: '.st-filter-item',
                  percentPosition: true,
                  transformsEnabled: false,
                  filter: '.monthly',
                  masonry: {
                      columnWidth: 0,
                      gutter:0
                  }
              });
              $(document).on('click', '.'+parentClass+' .st-tab-filter a', function () {
                  var filterValue = $(this).attr('data-filter');
                  festivarMasonry.isotope({
                      filter: filterValue,
                      animationOptions: {
                          duration: 450,
                          easing: "linear",
                          queue: false,
                      }
                  });
                  return false;
              });
          });
        } else {
          $($selector).imagesLoaded(function () {
            var festivarMasonry = $($selector).isotope({
                itemSelector: '.st-filter-item',
                percentPosition: true,
                masonry: {
                    columnWidth: 0,
                    gutter:0
                }
            });
            $(document).on('click', '.'+parentClass+' .st-tab-filter a', function () {
                var filterValue = $(this).attr('data-filter');
                festivarMasonry.isotope({
                    filter: filterValue,
                    animationOptions: {
                        duration: 450,
                        easing: "linear",
                        queue: false,
                    }
                });
                return false;
            });
          });
        }
    });
    $(document).on('click', '.st-tab-filter a', function () {
      $(this).siblings().removeClass('active');
      $(this).addClass('active');
    });

    // Tab Swipe Indicator
    $('.tab-swipe-filter').append('<span class="indicator"></span>');
    if ($('.tab-swipe-filter a').hasClass('active')) {
        let cLeft = $('.tab-swipe-filter a.active').position().left + 'px',
            cWidth = $('.tab-swipe-filter a.active').css('width');
        $('.indicator').css({
            left: cLeft,
            width: cWidth
        })
    }
    $('.tab-swipe-filter a').on('click', function () {
        $('.tab-swipe-filter a').removeClass('is-active');
        $(this).addClass('is-active');
        let cLeft = $('.tab-swipe-filter a.is-active').position().left + 'px',
            cWidth = $('.tab-swipe-filter a.is-active').css('width');
        $('.indicator').css({
            left: cLeft,
            width: cWidth
        })
    });
  });

	// Recent Product Carousel
  var owlRecentProducts = $(".recent-products-carousel .woocommerce .products");
  owlRecentProducts.each(function () {
      $(this).addClass('owl-carousel owl-theme');
  });
  owlRecentProducts.owlCarousel({
	  rtl: $("html").attr("dir") == 'rtl' ? true : false,
	  loop: true,
	  nav: false,
	  dots: false,
	  margin: 20,
	  mouseDrag: true,
	  touchDrag: true,
	  autoplay: true,
	  autoplayTimeout: 12000,
	  stagePadding: 0,
	  autoHeight: true,
	  responsive: {
		  0: {
			  items: 1
		  },
		  768: {
			  items: 3
		  },
		  992: {
			  items: 4
		  }
	  }
  });
  // Custom Button
  $('.recent-product-nav .owl-next').click(function() {
    owlRecentProducts.trigger('next.owl.carousel');
  });
  $('.recent-product-nav .owl-prev').click(function() {
    owlRecentProducts.trigger('prev.owl.carousel');
  });
  $( '.recent-products-carousel .owl-filter-bar' ).on( 'click', '.item', function() {
      var $item = $(this);
      var filter = $item.data( 'owl-filter' )
      owlRecentProducts.owlcarousel2_filter( filter );
  });


  // Featured Product Carousel
  var owlFeaturedProducts = $(".featured-products-carousel .woocommerce .products");
  owlFeaturedProducts.each(function () {
      $(this).addClass('owl-carousel owl-theme');
  });
  owlFeaturedProducts.owlCarousel({
    rtl: $("html").attr("dir") == 'rtl' ? true : false,
    loop: true,
    nav: false,
    dots: false,
    margin: 20,
    mouseDrag: true,
    touchDrag: true,
    autoplay: true,
    autoplayTimeout: 12000,
    stagePadding: 0,
    autoHeight: true,
    responsive: {
      0: {
        items: 1
      },
      768: {
        items: 3
      },
      992: {
        items: 4
      }
    }
  });
  // Custom Button
  $('.featured-product-nav .owl-next').click(function() {
    owlFeaturedProducts.trigger('next.owl.carousel');
  });
  $('.featured-product-nav .owl-prev').click(function() {
    owlFeaturedProducts.trigger('prev.owl.carousel');
  });
  $( '.featured-products-carousel .owl-filter-bar' ).on( 'click', '.item', function() {
      var $item = $(this);
      var filter = $item.data( 'owl-filter' )
      owlFeaturedProducts.owlcarousel2_filter( filter );
  });


  // Best Product Carousel
  var owlBestProducts = $(".best-products-carousel .woocommerce .products");
  owlBestProducts.each(function () {
      $(this).addClass('owl-carousel owl-theme');
  });
  owlBestProducts.owlCarousel({
    rtl: $("html").attr("dir") == 'rtl' ? true : false,
    loop: true,
    nav: false,
    dots: false,
    margin: 20,
    mouseDrag: true,
    touchDrag: true,
    autoplay: true,
    autoplayTimeout: 12000,
    stagePadding: 0,
    autoHeight: true,
    responsive: {
      0: {
        items: 1
      },
      768: {
        items: 3
      },
      992: {
        items: 4
      }
    }
  });
  // Custom Button
  $('.best-products-carousel .best-product-nav .owl-next').click(function() {
    owlBestProducts.trigger('next.owl.carousel');
  });
  $('.best-products-carousel .best-product-nav .owl-prev').click(function() {
    owlBestProducts.trigger('prev.owl.carousel');
  });
  $( '.best-products-carousel .owl-filter-bar' ).on( 'click', '.item', function() {
      var $item = $(this);
      var filter = $item.data( 'owl-filter' )
      owlBestProducts.owlcarousel2_filter( filter );
  });


  // Best Product Carousel
  var owlBestProducts = $(".best-deals-carousel .col-lg-12 .products");
  owlBestProducts.each(function () {
      $(this).addClass('owl-carousel owl-theme');
  });
  owlBestProducts.owlCarousel({
    rtl: $("html").attr("dir") == 'rtl' ? true : false,
    loop: true,
    nav: false,
    dots: false,
    margin: 20,
    mouseDrag: true,
    touchDrag: true,
    autoplay: false,
    autoplayTimeout: 12000,
    stagePadding: 0,
    autoHeight: true,
    responsive: {
      0: {
        items: 1
      },
      768: {
        items: 2
      },
      992: {
        items: 2
      }
    }
  });
  // Custom Button
  $('.best-deals-carousel .best-product-nav .owl-next').click(function() {
    owlBestProducts.trigger('next.owl.carousel');
  });
  $('.best-deals-carousel .best-product-nav .owl-prev').click(function() {
    owlBestProducts.trigger('prev.owl.carousel');
  });
  $( '.best-deals-carousel .owl-filter-bar' ).on( 'click', '.item', function() {
      var $item = $(this);
      var filter = $item.data( 'owl-filter' )
      owlBestProducts.owlcarousel2_filter( filter );
  });


  $('.bn-breaking-news').each(function() {
    var brbId = this.id;
    $('[id*="newsOffer"]').breakingNews();
  });

}(jQuery));

