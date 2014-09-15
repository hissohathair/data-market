# 
# Dockerfile for Data Market prototype
#
# We build on phusion/passenger-docker. Get latest build number from here:
#	https://github.com/phusion/passenger-docker/blob/master/Changelog.md
#
FROM phusion/passenger-nodejs
MAINTAINER Daniel Austin <daniel.austin@smartservicescrc.com.au>

# Set correct environment variables.
ENV HOME /root


# Enable Nginx & Passenger
# [TODO: For now, just running Node.js directly]
#
##RUN rm -f /etc/service/nginx/down
##ADD ./conf/nginx.conf /etc/nginx/nginx.conf
##ADD ./conf/nginx-default.conf /etc/nginx/sites-available/default
##ADD ./conf/data-market.conf /etc/nginx/sites-enabled/data-market.conf


# Node.js should already be installed. Make sure NPM is also there.
#
RUN apt-get -y install npm


# Place web app in /home/app
#
RUN mkdir /home/app/data-market
ADD ./lib /home/app/data-market/lib
ADD ./public /home/app/data-market/public
ADD ./routes /home/app/data-market/routes
ADD ./views /home/app/data-market/views
ADD ./app.js /home/app/data-market/app.js
ADD ./package.json /home/app/data-market/package.json

RUN mkdir /etc/service/data-market
ADD ./conf/data-market.sh /etc/service/data-market/run
RUN chmod 755 /etc/service/data-market/run

RUN cd /home/app/data-market && npm install


# Clean up and run
#
##EXPOSE 443
EXPOSE 3000

# Clean up APT when done.
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Use baseimage-docker's init process.
CMD ["/sbin/my_init"]

