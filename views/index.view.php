<?php
// graphiql.php
?>
<!DOCTYPE html>
<html>

<head>
  <!-- GraphiQL CSS from CDN -->
  <link rel="stylesheet" href="https://unpkg.com/graphiql/graphiql.min.css" />
  <!-- React and ReactDOM (required by GraphiQL) from CDN -->
  <script src="https://unpkg.com/react/umd/react.production.min.js"></script>
  <script src="https://unpkg.com/react-dom/umd/react-dom.production.min.js"></script>
  <!-- GraphiQL JS from CDN -->
  <script src="https://unpkg.com/graphiql/graphiql.min.js"></script>
  <style>
    body {
      height: 100%;
      margin: 0;
      width: 100%;
      overflow: hidden;
    }

    #graphiql {
      height: 100vh;
    }
  </style>
</head>

<body>
  <!-- GraphiQL Container -->
  <div id="graphiql">Loading...</div>

  <script>
    // Function to send GraphQL queries to your PHP backend
    function graphQLFetcher(graphQLParams) {
      return fetch('http://localhost/:80', { // Adjust to your GraphQL endpoint
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(graphQLParams),
        })
        .then(function(response) {
          return response.json();
        });
    }

    // Render the GraphiQL interface
    ReactDOM.render(
      React.createElement(GraphiQL, {
        fetcher: graphQLFetcher
      }),
      document.getElementById('graphiql'),
    );
  </script>
</body>

</html>