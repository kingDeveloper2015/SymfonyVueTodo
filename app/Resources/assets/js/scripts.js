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
        todos: []
    },
    methods: {
        addTodo: function(){
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
            //this.todos.push({ description: description, is_complete: false });
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
