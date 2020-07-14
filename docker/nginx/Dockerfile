FROM alpine:3.12

RUN apk add --update --no-cache nginx=1.18.0-r0
RUN mkdir -p /run/nginx
COPY nginx.conf /etc/nginx/
COPY jobs.conf /etc/nginx/conf.d/default.conf

RUN echo "upstream php-upstream { server php-fpm:9000; }" > /etc/nginx/conf.d/upstream.conf

CMD ["nginx"]

EXPOSE 80
EXPOSE 443
