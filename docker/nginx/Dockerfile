FROM nginx:1.21.3-alpine

COPY nginx/nginx.conf /etc/nginx/
COPY nginx/fastcgi.conf /etc/nginx/

RUN apk update \
    && apk upgrade \
    && apk add --no-cache openssl \
    && apk --update add logrotate \
    && apk add --no-cache bash

RUN apk add --no-cache curl

RUN set -x ; \
    addgroup -g 82 -S www-data ; \
    adduser -u 82 -D -S -G www-data www-data && exit 0 ; exit 1

#
# Copy application sources
#
WORKDIR /var/www

RUN chown -R www-data:www-data /var/www/

# Create 'messages' file used from 'logrotate'
RUN touch /var/log/messages

# Copy 'logrotate' config file
COPY nginx/logrotate/nginx /etc/logrotate.d/

# Create directory for SSL certificates
# RUN mkdir -p /etc/nginx/ssl

#
# Update sites configuration
#
RUN rm /etc/nginx/conf.d/*

# RUN mkdir -p /etc/nginx/sites-available
RUN mkdir -p /etc/nginx/locations
COPY nginx/locations/*.conf /etc/nginx/locations/
# COPY nginx/sites/*.conf /etc/nginx/sites-available/

#
# Run nginx
#
ADD nginx/startup.sh /opt/startup.sh
RUN sed -i 's/\r//g' /opt/startup.sh
CMD ["/bin/bash", "/opt/startup.sh"]

EXPOSE 80 81 443 8080
