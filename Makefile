dockerip=foo

insecure_key:
	curl -o insecure_key -fSL https://github.com/phusion/baseimage-docker/raw/master/image/insecure_key
	chmod 600 insecure_key

ssh: insecure_key
	docker inspect `docker ps | grep smartservicescrc/data-market | awk '{print $$1}'` | grep -m1 IPAddress | awk -F: '{print $$2}' | sed s/[\",]//g 1>.docker_ip
	ssh -i insecure_key root@`cat .docker_ip`

