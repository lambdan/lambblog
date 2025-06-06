FROM python:3.7 AS build

RUN pip3 install markdown2==2.4.8
RUN pip3 install PyRSS2Gen==1.1
RUN pip3 install beautifulsoup4==4.13.4
RUN pip3 install python-slugify==8.0.4
RUN pip3 install python-dateutil==2.9.0
RUN pip3 install tqdm==4.67.1
RUN pip3 install requests==2.31.0
RUN pip3 install pillow==9.5.0
RUN pip install boto3==1.33.13
RUN pip install pytz==2025.2

WORKDIR /build

COPY ./posts /build/posts
COPY ./includes /build/includes
COPY ./pages /build/pages
COPY ./generate_site.py /build/generate_site.py

ARG AWS_ACCESS_KEY_ID
ARG AWS_SECRET_ACCESS_KEY
ARG BASE_URL="http://localhost:80/"

RUN python3 generate_site.py -url "${BASE_URL}" -y -v --s3-bucket "lambblog" --s3-region "eu-north-1"

FROM nginx:alpine AS final
COPY ./nginx.conf /etc/nginx/conf.d/default.conf
COPY --from=build /build/_output /html



