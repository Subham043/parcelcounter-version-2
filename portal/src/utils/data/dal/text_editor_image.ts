import type { GenericAbortSignal } from "axios";
import type { TextEditorImageFormValuesType } from "../schema/text_editor_image";
import { api_routes } from "@/utils/routes/api_routes";
import axios from "@/utils/axios";
import type { TextEditorImageType } from "@/utils/types";



export const createTextEditorImageHandler = async (val: TextEditorImageFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: TextEditorImageType }>(api_routes.text_editor_image.create, val, { signal, headers: { "Content-Type": "multipart/form-data" } });
    return response.data.data;
}