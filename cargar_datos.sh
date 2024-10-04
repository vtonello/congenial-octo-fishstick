#!/bin/bash

generate_doc_number() {
    echo $((RANDOM % 90000000 + 10000000))
}

# Array de personajes de DC Comics
declare -a characters=(
    "Bruce Wayne,Batman,ID"
    "Clark Kent,Superman,AL"
    "Diana Prince,Wonder Woman,AP"
    "Barry Allen,The Flash,CC"
    "Hal Jordan,Green Lantern,PL"
    "Arthur Curry,Aquaman,AN"
    "Oliver Queen,Green Arrow,SS"
    "Dick Grayson,Nightwing,MI"
    "Barbara Gordon,Batgirl,LC"
    "Kara Zor-El,Supergirl,KR"
    "J'onn J'onzz,Martian Manhunter,MA"
    "Dinah Lance,Black Canary,SC"
    "Victor Stone,Cyborg,TI"
    "Billy Batson,Shazam,WW"
    "Zatanna Zatara,Zatanna,MM"
    "John Constantine,Constantine,OC"
    "Selina Kyle,Catwoman,TF"
    "Harvey Dent,Two-Face,JD"
    "Harleen Quinzel,Harley Quinn,PA"
    "Pamela Isley,Poison Ivy,BT"
    "Edward Nygma,The Riddler,PP"
    "Oswald Cobblepot,Penguin,BC"
    "Slade Wilson,Deathstroke,AS"
    "Ra's al Ghul,Ra's al Ghul,IM"
    "Lex Luthor,Lex Luthor,GN"
    "Darkseid,Darkseid,AP"
    "Brainiac,Brainiac,AI"
    "Sinestro,Sinestro,YL"
    "Black Adam,Black Adam,MA"
    "Gorilla Grodd,Gorilla Grodd,TE"
    "Captain Cold,Captain Cold,CR"
    "Mister Freeze,Mister Freeze,CF"
    "Cheetah,Cheetah,FW"
    "Bizarro,Bizarro,CL"
    "Doomsday,Doomsday,KR"
    "Lobo,Lobo,CZ"
    "Atrocitus,Atrocitus,RL"
    "Brainiac 5,Brainiac 5,FI"
    "Kilowog,Kilowog,GL"
    "Mera,Mera,AT"
    "Hawkman,Hawkman,TH"
    "Hawkgirl,Hawkgirl,SW"
    "John Stewart,Green Lantern,ML"
    "Guy Gardner,Green Lantern,RL"
    "Jonah Hex,Jonah Hex,BH"
    "Etrigan,Etrigan,DK"
    "Swamp Thing,Swamp Thing,EP"
    "Doctor Fate,Doctor Fate,MH"
    "Deadshot,Deadshot,SS"
    "Amanda Waller,Amanda Waller,GV"
)

API_URL="http://0.0.0.0:9080/api.php"


for i in {1..50}
do
    index=$((RANDOM % ${#characters[@]}))
    IFS=',' read -ra char <<< "${characters[$index]}"

    nombre="${char[0]}"
    apellido="${char[1]}"
    tipo_documento="${char[2]}"
    numero_documento=$(generate_doc_number)

    # Crear el JSON para la llamada a la API
    json_data=$(cat <<EOF
{
    "nombre": "$nombre",
    "apellido": "$apellido",
    "tipo_documento": "$tipo_documento",
    "numero_documento": "$numero_documento"
}
EOF
)

    # Realizar la llamada a la API
    response=$(curl -s -X POST -H "Content-Type: application/json" -d "$json_data" $API_URL)

    echo "Insertando: $nombre $apellido"
    echo "Respuesta: $response"
    echo "------------------------"
done

echo "FIN !"