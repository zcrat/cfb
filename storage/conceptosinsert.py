import pandas as pd
import mysql.connector

def insertar_datos_excel_a_mysql(ruta_excel, usuario_db, contrasena_db, host_db, nombre_db):
    # Leer el archivo Excel
    df = pd.read_excel(ruta_excel)

    # Conectar a la base de datos MySQL
    conexion = mysql.connector.connect(
        host=host_db,
        user=usuario_db,
        password=contrasena_db,
        database=nombre_db
    )
    cursor = conexion.cursor()
    # count=0
    try:
        for index, fila in df.iterrows():
            descripcion = fila['descripcion']
            pCFECategorias_id = fila['pcfecategoria']
            contrato_id = 3
            # count += 1
            num = fila['num']
            codigo_sat = fila['codigo sat']
            # Procesar las columnas relacionadas con -4, -6, -8
            for sufijo in [1017,1018,1019,1020,1021,1022,1023,1024]:
                p_mo = 0
                p_refaccion = fila[f'prefaccion_{sufijo}']
                p_total = fila[f'prefaccion_{sufijo}']

                # Insertar en la tabla pcfeconceptos
                if p_refaccion>0:
                    consulta_conceptos = """
                    INSERT INTO pcfeconceptos (descripcion, p_mo, p_refaccion, p_total, pCFECategorias_id, codigo_sat,num,pCFETipos_id,tiempo,codigo_unidad,unidad_text,id_anio_correspondiente,contrato_id,CFE_id)
                    VALUES (%s, %s, %s, %s, %s, %s,%s, %s, %s, %s, %s, %s, %s, %s)
                    """
                    cursor.execute(consulta_conceptos, (descripcion, p_mo, p_refaccion, p_total, pCFECategorias_id, codigo_sat,num,sufijo,'1.0','H87','Pieza','3',contrato_id,2))
                else:
                     print("Datos no insertados")
                # if count == 1:
                #     consulta_tipos = """
                #     INSERT INTO tipos_disponibles (id_tipo, id_modulo, id_sucursal, id_anio)
                #     VALUES (%s, %s, %s, %s)
                #     """
                #     cursor.execute(consulta_tipos, (sufijo,2,contrato_id,3))
        # Confirmar los cambios
        conexion.commit()
        print("Datos insertados correctamente.")

    except Exception as e:
        print(f"Ocurrió un error: {e}")
        conexion.rollback()

    finally:
        # Cerrar la conexión
        cursor.close()
        conexion.close()

# Configuración

ruta_excel = "C:/Users/jchug/Downloads/conceptosdiesel.xlsx"
usuario_db = "root"
contrasena_db = ""
host_db = "127.0.0.1"
nombre_db = "cfbtac"

insertar_datos_excel_a_mysql(ruta_excel, usuario_db, contrasena_db, host_db, nombre_db)
