docker run -t -v "C:/OSRM-DATA:/data" osrm/osrm-backend osrm-extract -p /opt/car.lua /data/kazakhstan-latest.osm.pbf
docker run -t -v "C:/OSRM-DATA:/data" osrm/osrm-backend osrm-partition /data/kazakhstan-latest.osrm
docker run -t -v "C:/OSRM-DATA:/data" osrm/osrm-backend osrm-customize /data/kazakhstan-latest.osrm
docker run -t -i -p 5000:5000 -v "C:/OSRM-DATA:/data" osrm/osrm-backend osrm-routed --algorithm mld /data/kazakhstan-latest.osrm
