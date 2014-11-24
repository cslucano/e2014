import pymongo
import psycopg2

pgconn = psycopg2.connect(host='localhost', dbname='e2014', user='e2014', password='e2014')
pgcur = pgconn.cursor()

mgconn = pymongo.MongoClient('localhost')
db = mgconn.candidatos2014
coll = db.educacion_basica

cursor = coll.find()

for escoll in cursor:
    if len(escoll['d']) > 0 :
        for es in escoll['d']:         
            pgcur.execute(
                "INSERT INTO educacionsuperior_stage (candidato_jne_id, fe_mod, id_educacion, mes_inicio, pais, fg_no_universitario, fg_estudio_realizado, nombre_estudio, lugar_estudio, fg_estado, fg_hasta_actualidad, ano_inicio, tipo_documento, tipo_postgrado, mes_final, cod_anr, eli, nombre_centro, cre, tipo_grado, fg_extrangero, otro_tipo_documento, nombre_carrera, otro_tipo_grado, tipo_estudio, fg_concluido, ano_final, ubigeo) values (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)", (
                    escoll['candidato_id'],
                    es['strFeMod'],
                    es['intIdEducacion'],
                    es['intMesInicio'],
                    es['strPais'],
                    es['strFgNoUniversitario'],
                    es['strFgEstudioRealizado'],
                    es['strNombreEstudio'],
                    es['strLugarEstudio'],
                    es['strFgEstado'],
                    es['strFgHastaActualidad'],
                    es['intAnioInicio'],
                    es['strTipoDocumento'],
                    es['intTipoPostgrado'],
                    es['intMesFinal'],
                    es['strCodANR'],
                    es['strEli'],
                    es['strNombreCentro'],
                    es['strCre'],
                    es['strTipoGrado'],
                    es['strFgExtranjero'],
                    es['strOtroTipoDocumento'],
                    es['strNombreCarrera'],
                    es['strOtroTipoGrado'],
                    es['objTipoEstudioBE']['intTipo'],
                    es['strFgConcluido'],
                    es['intAnioFinal'],
                    es['objUbigeoBE']['strUbigeo']
                )
            )
            pgconn.commit()

pgconn.close()    
mgconn.close()
