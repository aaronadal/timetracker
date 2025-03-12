FROM nginx:latest

COPY docker/nginx.conf /etc/nginx/conf.d/default.conf.template
COPY docker/nginx.sh /nginx.sh
RUN chmod +x /nginx.sh

ENTRYPOINT ["/nginx.sh"]
CMD ["nginx", "-g", "daemon off;"]
