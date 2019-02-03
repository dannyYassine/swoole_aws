start:
	cd scripts/; \
	./server.sh

stop:
	cd scripts/; \
	./stop_server.sh

restart:
	cd scripts/; \
	./restart.sh

start-dev:
	cd scripts/; \
	./server.dev.sh

stop-dev:
	cd scripts/; \
	./stop_server.dev.sh

restart-dev:
	cd scripts/; \
	./restart.dev.sh