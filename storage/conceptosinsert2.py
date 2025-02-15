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

    try:
        for index, fila in df.iterrows():
            descripcion = fila['descripcion']
            pCFECategorias_id = fila['pcfecategoria']
            contrato_id = 5
            num = fila['num']
            codigo_sat = fila['codigo sat']
            # Procesar las columnas relacionadas con -4, -6, -8
            for sufijo in ['1011','1012','1013','1014' ,'1015','1016']:
                p_mo = fila[f'pmo']
                p_refaccion = fila[f'prefaccion_{sufijo}']
                p_total = int(p_mo) + int(p_refaccion)

                # Insertar en la tabla pcfeconceptos
                if(p_total>0):
                    consulta_conceptos = """
                    INSERT INTO pcfeconceptos (descripcion, p_mo, p_refaccion, p_total, pCFECategorias_id, codigo_sat,num,pCFETipos_id,tiempo,codigo_unidad,unidad_text,id_anio_correspondiente,contrato_id,CFE_id)
                    VALUES (%s, %s, %s, %s, %s, %s,%s, %s, %s, %s, %s, %s, %s, %s)
                    """
                    cursor.execute(consulta_conceptos, (descripcion, p_mo, p_refaccion, p_total, pCFECategorias_id, codigo_sat,num,sufijo,'1.0','H87','Pieza','3',contrato_id,2))


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

ruta_excel = "C:/Users/jchug/Downloads/conceptosbajiodisel1.xlsx"
usuario_db = "root"
contrasena_db = ""
host_db = "127.0.0.1"
nombre_db = "cfbtac"

insertar_datos_excel_a_mysql(ruta_excel, usuario_db, contrasena_db, host_db, nombre_db)
