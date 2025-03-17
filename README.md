# TimeTracker — A very basic time tracking app

## Getting started

In order to run this app locally, you need to have [Docker](https://www.docker.com/) installed in your computer.

Once Docker is installed and running, you just have to execute the following commands:

1. Build the custom docker images with `make build`.
2. Deploy the Docker Compose containers with `make start`.
3. Install all the required dependencies with `make install`.
4. Run the database migrations with `make prepare`.

That's all. Now you can check the api is ready at [localhost:8000](http://localhost:8000)
and launch the app at [localhost:3000](http://localhost:3000).

### Testing the application

You can run the test suites separately for backend and frontend executing the following commands:

- `make test-backend`
- `make test-frontend`

You can also run both at the same time running `make test`

These commands run both, unit and static-analysis tests.
