new Vue({
    el: '#app',

    ready: function() {

        // GET request
        this.$http.get('/api/todos', function (data, status, request) {

            data = JSON.parse(data);
            console.log(data);
            this.todos = data;
        })

    },

    data: {
        todos: [
        ],
    }
});