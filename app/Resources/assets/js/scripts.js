var app = {

    init: function(){
        this.cacheDom();
        this.bindEvents();
    },
    cacheDom: function(){
        this.el         = document.getElementById("seo-form");
        this.modal      = $('.modal');
        this.bar        = $('#progress-bar');
    },
    bindEvents: function(){
        if(this.el){
            this.el.addEventListener("submit", this.ajaxPost.bind(this));
        }
    },
    ajaxPost: function(){

        var value = 0;

        this.modal.fadeIn( "slow", function() {
        }).bind(this);

        setInterval(function(){
            value = value + 0.1;
            $('#progress-bar').val(value);
        }, 5);

    }

};


app.init();