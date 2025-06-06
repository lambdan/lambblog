FROM python:3.7 AS build

RUN pip install -q \
    markdown2==2.4.8 \
    PyRSS2Gen==1.1 \
    beautifulsoup4==4.13.4 \
    python-slugify==8.0.4 \
    python-dateutil==2.9.0 \
    tqdm==4.67.1 \
    requests==2.31.0 \
    pillow==9.5.0 \
    boto3==1.33.13 \
    pytz==2025.2

WORKDIR /build

COPY ./posts /build/posts
COPY ./includes /build/includes
COPY ./pages /build/pages
COPY ./generate_site.py /build/generate_site.py

ARG AWS_ACCESS_KEY_ID
ARG AWS_SECRET_ACCESS_KEY
ARG BASE_URL="http://localhost:80/"

RUN python3 generate_site.py -url "${BASE_URL}" -y --s3-bucket "lambblog" --s3-region "eu-north-1"

FROM nginx:alpine AS final
COPY ./nginx.conf /etc/nginx/conf.d/default.conf
COPY --from=build /build/_output /html



