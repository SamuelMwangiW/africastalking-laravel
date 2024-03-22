FROM node:lts-alpine as build

WORKDIR /app

COPY . .

RUN apk add --no-cache git && \
    npm ci && \
    npm run docs:build

FROM nginx:stable-alpine

LABEL org.opencontainers.image.source="https://github.com/SamuelMwangiW/africastalking-laravel"
LABEL org.opencontainers.image.licenses="MIT"

COPY --from=build /app/.vitepress/dist /usr/share/nginx/html

EXPOSE 80
