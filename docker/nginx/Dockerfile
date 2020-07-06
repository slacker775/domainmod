#ARG ASSET_IMAGE

#FROM ${ASSET_IMAGE} AS assets
FROM domainmod_app AS assets

FROM nginx:latest

COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

COPY --from=assets /var/www/public /var/www/public