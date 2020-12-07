FROM  nginx:alpine as base
COPY  .docker/nginx/conf/nginx.conf /etc/nginx/conf.d/default.conf
RUN mkdir /app

FROM base as prod
COPY ./ /app