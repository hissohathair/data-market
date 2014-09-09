# 
# Dockerfile for Data Market prototype
#
# We build on phusion/passenger-docker. Get latest build number from here:
#	https://github.com/phusion/passenger-docker/blob/master/Changelog.md
#
#FROM phusion/passenger-full:0.9.11
FROM phusion/passenger-customizable:0.9.11
MAINTAINER Daniel Austin <daniel.austin@smartservicescrc.com.au>

# Set correct environment variables.
ENV HOME /root

# Use baseimage-docker's init process.
CMD ["/sbin/my_init"]

# Build system and git.
RUN apt-get update
RUN apt-get -y upgrade
RUN /build/utilities.sh

# Common development headers necessary for many libraries
RUN /build/devheaders.sh

# Node.js and Meteor support.
RUN /build/nodejs.sh

# Enable Nginx & Passenger
RUN rm -f /etc/service/nginx/down
ADD ./conf/nginx.conf /etc/nginx/nginx.conf
ADD ./conf/nginx-default.conf /etc/nginx/sites-available/default
ADD ./conf/webapp.conf /etc/nginx/sites-enabled/webapp.conf

# TODO: RUN ...commands to place your web app in /home/app/webapp..
RUN mkdir /home/app/webapp

# Private expose web port
EXPOSE 80

# Clean up APT when done.
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

