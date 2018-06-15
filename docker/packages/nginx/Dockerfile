FROM nginx:stable-alpine

COPY nginx.conf /etc/nginx

RUN apk update \
    && apk upgrade \
    && apk add --no-cache bash \
    && adduser -D -H -u 1000 -s /bin/bash www-data

RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf \
    && rm /etc/nginx/conf.d/default.conf

CMD ["nginx"]

WORKDIR /var/www

EXPOSE 80 443