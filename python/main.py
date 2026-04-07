from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from queue_manager import QueueManager

app = FastAPI(title="Queuing System API")

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["*"],
    allow_headers=["*"],
)

queue = QueueManager()


class ResetRequest(BaseModel):
    start: int = 1
    end: int = 100


@app.get("/status")
def get_status():
    return {
        "regular": queue.regular.status(),
        "priority": queue.priority.status(),
    }


@app.post("/next/{queue_type}")
def next_number(queue_type: str):
    q = queue.get_queue(queue_type)
    result = q.next()
    if "error" in result:
        raise HTTPException(status_code=400, detail=result["error"])
    return result


@app.post("/skip/{queue_type}")
def skip_number(queue_type: str):
    q = queue.get_queue(queue_type)
    result = q.skip()
    if "error" in result:
        raise HTTPException(status_code=400, detail=result["error"])
    return result


@app.post("/reset/{queue_type}")
def reset_queue(queue_type: str, body: ResetRequest):
    q = queue.get_queue(queue_type)
    q.reset(body.start, body.end)
    return {"message": "Queue reset successfully", **q.status()}