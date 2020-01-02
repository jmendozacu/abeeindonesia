define(['jquery'], function( $ ) {
    return function( config, element ) {
        'use strict';

        var timerID = config.timerID,
            startDate = new Date(config.startDate),
            endDate = new Date(Date.parse(config.endDate)),
            dateDiff = new Date((endDate)-(startDate)),
            secondsDiff = Math.floor(dateDiff.valueOf()/1000);

        var productTimer = {
            init: function(secondsDiff, id){
                var daysHolder = $('.timer-'+id+' .days');
                var hoursHolder = $('.timer-'+id+' .hours');
                var minutesHolder = $('.timer-'+id+' .minutes');
                var secondsHolder = $('.timer-'+id+' .seconds');
                var timerId = $('.timer-'+id);
                var firstLoad = true;
                productTimer.timer(secondsDiff, daysHolder, hoursHolder, minutesHolder, secondsHolder, timerId, firstLoad);
                setTimeout(function(){
                    $('.timer-box').css('display', 'block');
                }, 1100);
            },
            timer: function(secondsDiff, daysHolder, hoursHolder, minutesHolder, secondsHolder, timerId, firstLoad){
                setTimeout(function(){
                    var days = Math.floor(secondsDiff/86400);
                    var hours = Math.floor((secondsDiff/3600)%24);
                    var minutes = Math.floor((secondsDiff/60)%60);
                    var seconds = secondsDiff%60;

                    $(timerId).each(function(){
                        secondsHolder = $(this).find('.seconds');
                        var secondsActive =  $(secondsHolder).find('.flip-item.active');
                        var secondsBefore = $(secondsHolder).find('.flip-item.before');
                        if (seconds > 9) {
                            $(secondsBefore).find('.flip-text').html(seconds);
                        } else {
                            $(secondsBefore).find('.flip-text').html('0'+seconds);
                        }
                        secondsBefore.off().removeClass('before').addClass('active');
                        secondsActive.off().removeClass('active').addClass('before');
                    });

                    if(firstLoad == true){
                        if (seconds > 9) {
                            secondsHolder.find('.flip-text').html(seconds);
                        } else {
                            secondsHolder.find('.flip-text').html('0'+seconds);
                        }
                        if (days > 9) {
                            daysHolder.find('.flip-text').html(days);
                        } else {
                            daysHolder.find('.flip-text').html('0'+days);
                        }
                        if (hours > 9) {
                            hoursHolder.find('.flip-text').html(hours);
                        } else {
                            hoursHolder.find('.flip-text').html('0'+hours);
                        }
                        if (minutes > 9) {
                            minutesHolder.find('.flip-text').html(minutes);
                        } else {
                            minutesHolder.find('.flip-text').html('0'+minutes);
                        }
                        firstLoad = false;
                    }
                    if(seconds >= 59){
                        $(timerId).each(function(){
                            var currentTimer = $(this);
                            minutesHolder = currentTimer.find('.minutes');
                            hoursHolder = currentTimer.find('.hours');
                            daysHolder = currentTimer.find('.days');
                            if (parseInt(minutesHolder.find('.flip-item.before .flip-up .flip-text').text()) != minutes) {
                                if (minutes > 9) {
                                    minutesHolder.find('.flip-item.before .flip-text').html(minutes);
                                } else {
                                    minutesHolder.find('.flip-item.before .flip-text').html('0'+minutes);
                                }
                                var minutesActive =  $(minutesHolder).find('.flip-item.active');
                                var minutesBefore = $(minutesHolder).find('.flip-item.before');
                                minutesBefore.removeClass('before').addClass('active');
                                minutesActive.removeClass('active').addClass('before');
                            }
                            if (parseInt(hoursHolder.find('.flip-item.before .flip-up .flip-text').text()) != hours) {
                                if (hours > 9) {
                                    hoursHolder.find('.flip-item.before .flip-text').html(hours);
                                } else {
                                    hoursHolder.find('.flip-item.before .flip-text').html('0'+hours);
                                }
                                var hoursActive =  $(hoursHolder).find('.flip-item.active');
                                var hoursBefore = $(hoursHolder).find('.flip-item.before');
                                hoursBefore.removeClass('before').addClass('active');
                                hoursActive.removeClass('active').addClass('before');
                            }
                            if (parseInt(daysHolder.find('.flip-item.before .flip-up .flip-text').text()) != days) {
                                if (days > 9) {
                                    daysHolder.find('.flip-item.before .flip-text').html(days);
                                } else {
                                    daysHolder.find('.flip-item.before .flip-text').html('0'+days);
                                }
                                daysHolder.find('.flip-item.before .flip-text').html(days);
                                var daysActive =  $(daysHolder).find('.flip-item.active');
                                var daysBefore = $(daysHolder).find('.flip-item.before');
                                daysBefore.removeClass('before').addClass('active');
                                daysActive.removeClass('active').addClass('before');
                            }
                        });
                    }
                    secondsDiff--;
                    productTimer.timer(secondsDiff, daysHolder, hoursHolder, minutesHolder, secondsHolder, timerId, firstLoad);
                }, 1000);
            }
        };

        new productTimer.init(secondsDiff, timerID);

    }
})