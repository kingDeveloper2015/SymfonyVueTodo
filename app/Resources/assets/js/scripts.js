new Vue({
    el: '#app',

    ready: function() {
        this.$http.get('/api/todos', function (data, status, request) {
            data = JSON.parse(data);
            console.log(data);
            this.todos = data;
        })
    },

    data: {
        newTodo : '',
        todos: [],
        show: true
    },

    methods: {
        addTodo: function(){
            if(this.todos.length >= 10){
                alert('You are too busy bro... You can\'t have more than 10 Tasks')
            }
            var description = this.newTodo.trim();
            if (!description) {
                return;
            }
            this.$http.post('/api/todos', {description: description}).success(function(response) {
                console.log("Todo added!");
            }).error(function(error) {
                console.log(error);
            });
            this.$http.get('/api/todos', function (data, status, request) {
                data = JSON.parse(data);
                console.log(data);
                this.todos = data;
            })
            this.newTodo = '';
        },
        completeTodo: function(todo){
            var complete;
            var description = todo.description;

            if(todo.is_complete == false){
                complete =  true;
            }
            else{
                complete =  false;
            }

            this.$http.put('/api/todos/' + todo.id, {description: description, is_complete: complete}).success(function(response) {
                console.log("Todo put :p!");
            }).error(function(error) {
                console.log(error);
            });
        },
        deleteTodo: function(todo){
            this.$http.delete('/api/todos/' + todo.id)
                .success(function(response) {
                     console.log('cewl');
                });
            this.todos.$remove(todo);
        }
    }
});
