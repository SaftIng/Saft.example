That file is a basic runable SPARQL endpoint and can handle ASK and SELECT queries. To do so:

  1. copy that file in a folder of your webserver
  2. execute composer update on the terminal to install all dependencies
  3. after that, it should handle SPARQL queries coming via query parameter.

Call

    http://localhost/PATH_TO_ENDPOINT/?query=YOUR_SPARQL_QUERY

to get a result.

That particular implementation provides access to a Virtuoso store, which is usually not necessary
due Virtuoso has its own SPARQL endpoint. It is for demonstration purposes only, and because of that
it currently only supports ASK and SELECT queries.

That implementation is Access-Control-Allow-Origin friendly.
